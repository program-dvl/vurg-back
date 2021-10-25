<?php

namespace App\Http\Controllers\Trade;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Validator;
use App\Repositories\Trade\TradeRepository;
use App\Repositories\Wallet\WalletRepository;
use App\Repositories\Offer\OfferRepository;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Events\StartTrade;
use Illuminate\Support\Facades\DB;
use App\Repositories\Transaction\TransactionRepository;
use App\Events\Notification;

class TradeController extends Controller
{
    /**
     * Create a new trade controller instance.
     *
     * @param  App\Models\User $state
     * @return void
     */
    public function __construct(
        TradeRepository $tradeRepository,
        WalletRepository $walletRepository,
        OfferRepository $offerRepository,
        TransactionRepository $transactionRepository
    ) {
        $this->tradeRepository = $tradeRepository;
        $this->walletRepository = $walletRepository;
        $this->offerRepository = $offerRepository;
        $this->transactionRepository = $transactionRepository;
    }

    /**
     * Start a trade
     * POST|HEAD /trade
     *
     * @param Request $request
     * @return Response
     */
    public function createTrade(Request $request)
    {
        try {

            // Server side validations
            $validation = [
                'offer_id' => 'required|exists:offers,id',
                'amount' => "required|regex:/^\d+(\.\d{1,2})?$/"
            ];

            $validator = Validator::make($request->all(), $validation);

            // If request parameter have any error
            if ($validator->fails()) {
                return $this->sendValidationError($validator->messages());
            }

            $offer = $this->offerRepository->getOfferDetailsByOfferId($request->offer_id);
            if (!$offer) {
                return $this->sendError('Offer not found', Response::HTTP_NOT_FOUND);
            }
            if ($offer->user_id == Auth::id()) {
                return $this->sendError('Unauthorized to perform this operation', Response::HTTP_UNAUTHORIZED);
            }
            if ($offer->offer_type == 1) {
                $wallet = $this->walletRepository->getUserWallet($offer->user_id, $offer->cryptocurreny_type);
                if (!$wallet) {
                    return $this->sendError('Wallet not found', Response::HTTP_NOT_FOUND);
                }
            } else {
                $wallet = $this->walletRepository->getUserWallet(Auth::id(), $offer->cryptocurreny_type);
                if (!$wallet) {
                    return $this->sendError('Wallet not found', Response::HTTP_NOT_FOUND);
                }
            }

            $bitgo_wallet = $this->walletRepository->getBitgoWallet($wallet->wallet_id, $offer->cryptocurreny_type);

            $market_rate = $this->offerRepository->getBitcoinPrice($offer->preferredCurrency->currency_code);
            $crypto_amount = $request->amount / $market_rate;
            $fee_amount = $crypto_amount / 100;
            # TODO: Identify the above amounts above the minimum
            $mytime = Carbon::now();
            $tradeData = [];
            $tradeData['offer_id'] = $request->offer_id;
            $tradeData['user_id'] = Auth::id();
            $tradeData['start_time'] = $mytime->toDateTimeString();
            $tradeData['currency_amount'] = $request->amount;
            $tradeData['crypto_amount'] = $crypto_amount - $fee_amount;
            $tradeData['fee_amount'] = $fee_amount;
            $tradeData['market_rate'] = $market_rate;
            $trade = $this->tradeRepository->start($tradeData);
            if (empty($bitgo_wallet)) {
                throw new \ErrorException('Wallet not found');
            }
            $wallet->balance = $bitgo_wallet['balance'] / 100000000;
            $wallet->save();
            if ($trade->crypto_amount > ($wallet->balance - $wallet->locked)) {
                throw new \ErrorException('Unable to create trade due to low balance');
            }
            DB::beginTransaction();
            $wallet->locked += $trade->crypto_amount;
            $wallet->save();
            $trade->status()->transitionTo('wait');
            DB::commit();
            // Start trade
            //event(new StartTrade($trade));
            $notificationId = 2; // For trade started notification
            $notificationText = 'Trade ' . $trade->id . ' escrow funded now';
            $modelId = $trade->id;
            event(new Notification($notificationId, $notificationText, $modelId));
            return $this->sendSuccess($trade, 'Trade started successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            if (isset($trade)) {
                $trade->status()->transitionTo('reject');
            }
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * Cancel a trade
     * GET|HEAD /trade/{tradeId}/cancel
     *
     * @param Request $request
     * @return Response
     */
    public function cancelTrade($tradeId)
    {
        try {
            $trade = $this->tradeRepository->tradeDetails($tradeId);
            if (!$trade) {
                return $this->sendError('Trade not found', Response::HTTP_NOT_FOUND);
            }
            $offer = $this->offerRepository->getOfferDetailsByOfferId($trade->offer_id);
            if (!$offer) {
                return $this->sendError('Offer not found', Response::HTTP_NOT_FOUND);
            }
            if ($offer->user_id != Auth::id() && $trade->user_id != Auth::id()) {
                return $this->sendError('Unauthorized to perform this operation', Response::HTTP_UNAUTHORIZED);
            }
            if ($offer->offer_type == 1) {
                $wallet = $this->walletRepository->getUserWallet($offer->user_id, $offer->cryptocurreny_type);
                if (!$wallet) {
                    return $this->sendError('Wallet not found', Response::HTTP_NOT_FOUND);
                }
            } else {
                $wallet = $this->walletRepository->getUserWallet($trade->user_id, $offer->cryptocurreny_type);
                if (!$wallet) {
                    return $this->sendError('Wallet not found', Response::HTTP_NOT_FOUND);
                }
            }
            DB::beginTransaction();
            $trade->status()->transitionTo('cancel');
            $wallet->locked -= $trade->crypto_amount;
            $wallet->save();
            DB::commit();
            return $this->sendSuccess($trade, 'Trade cancelled successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * Receive the payment for a trade.
     * 
     * GET|HEAD /trade/{tradeId}/receive
     *
     * @param Request $request
     * @return Response
     */
    public function receivePayment($tradeId)
    {
        try {
            $trade = $this->tradeRepository->tradeDetails($tradeId);
            if (!$trade) {
                return $this->sendError('Trade not found', Response::HTTP_NOT_FOUND);
            }
            $offer = $this->offerRepository->getOfferDetailsByOfferId($trade->offer_id);
            if (!$offer) {
                return $this->sendError('Offer not found', Response::HTTP_NOT_FOUND);
            }
            if ($offer->offer_type == 1) {
                if ($trade->user_id != Auth::id()) {
                    return $this->sendError('Unauthorized to perform this operation', Response::HTTP_UNAUTHORIZED);
                }
            } else {
                if ($offer->user_id != Auth::id()) {
                    return $this->sendError('Unauthorized to perform this operation', Response::HTTP_UNAUTHORIZED);
                }
            }
            $trade->status()->transitionTo('payment_received');
            return $this->sendSuccess($trade, 'Trade status changed to receive payment succcessfully');
        } catch (\Exception $e) {
            return $this->sendError();
        }
    }

    /**
     * Accept the payment for a trade
     * GET|HEAD /trade/{tradeId}/accept
     *
     * @param Request $request
     * @return Response
     */
    public function acceptPayment(Request $request, $tradeId)
    {
        try {
            $trade = $this->tradeRepository->tradeDetails($tradeId);
            if (!$trade) {
                return $this->sendError('Trade not found', Response::HTTP_NOT_FOUND);
            }
            $offer = $this->offerRepository->getOfferDetailsByOfferId($trade->offer_id);
            if (!$offer) {
                return $this->sendError('Offer not found', Response::HTTP_NOT_FOUND);
            }
            $offer_wallet = $this->walletRepository->getUserWallet($offer->user_id, $offer->cryptocurreny_type);
            if (!$offer_wallet) {
                return $this->sendError('Wallet not found', Response::HTTP_NOT_FOUND);
            }
            $trade_wallet = $this->walletRepository->getUserWallet($trade->user_id, $offer->cryptocurreny_type);
            if (!$trade_wallet) {
                return $this->sendError('Wallet not found', Response::HTTP_NOT_FOUND);
            }
            if ($offer->offer_type == 1) {
                if ($offer->user_id != Auth::id()) {
                    return $this->sendError('Unauthorized to perform this operation', Response::HTTP_UNAUTHORIZED);
                }
                $buyer_wallet = $trade_wallet;
                $seller_wallet = $offer_wallet;
            } else {
                if ($trade->user_id != Auth::id()) {
                    return $this->sendError('Unauthorized to perform this operation', Response::HTTP_UNAUTHORIZED);
                }
                $buyer_wallet = $offer_wallet;
                $seller_wallet = $trade_wallet;
            }

            $bitgo_wallet = $this->walletRepository->getBitgoWallet($buyer_wallet->wallet_id, $offer->cryptocurreny_type);
            if (!$bitgo_wallet) {
                return $this->sendError('Wallet not found', Response::HTTP_NOT_FOUND);
            }
            $status = $this->transactionRepository->transferCoinToAddress(
                $trade->crypto_amount,
                $trade->fee_amount,
                $bitgo_wallet['receiveAddress']['address']
            );
            if (!$status) {
                $apiStatus = Response::HTTP_UNPROCESSABLE_ENTITY;
                $apiMessage = 'Failed to send the coins';
                return $this->sendError($apiMessage, $apiStatus);
            }
            DB::beginTransaction();
            $trade->status()->transitionTo('done');
            $seller_wallet->locked -= $trade->crypto_amount;
            $seller_wallet->balance -= $trade->crypto_amount;
            $seller_wallet->save();
            $buyer_wallet->balance += $trade->crypto_amount;
            $buyer_wallet->save();
            DB::commit();
            return $this->sendSuccess($trade, 'Trade completed successfully');
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * Get the trade details
     * GET|HEAD /trade/{tradeId}
     *
     * @param Request $request
     * @return Response
     */
    public function tradeDetails(Request $request, $tradeId)
    {
        try {
            $trade = $this->tradeRepository->getActiveTradeDetails($tradeId);
            if (!$trade) {
                return $this->sendError('Trade not found', Response::HTTP_NOT_FOUND);
            }
            return $this->sendSuccess($trade, 'Trade details found succcessfully');
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * Get the trade history
     * GET|HEAD /trade-history
     *
     * @param Request $request
     * @return Response
     */
    public function tradeHistory(Request $request)
    {
        try {
            // Server side validations
            $validation = [
                'trade_type' => 'in:buy,sell',
                'start_date' => 'date_format:Y-m-d',
                'end_date' => 'date_format:Y-m-d'
            ];

            $validator = Validator::make($request->all(), $validation);

            // If request parameter have any error
            if ($validator->fails()) {
                return $this->sendValidationError($validator->messages());
            }

            $trades = $this->tradeRepository->getTradeHistory($request->all());
            if (!count($trades)) {
                return $this->sendError('No trade history found', Response::HTTP_NOT_FOUND);
            }
            return $this->sendSuccess($trades, 'Trade history found succcessfully');
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }
}
