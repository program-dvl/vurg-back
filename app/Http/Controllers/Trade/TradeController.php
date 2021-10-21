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
use App\Services\BitGoSDK;
use neto737\BitGoSDK\Enum\CurrencyCode;

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
        OfferRepository $offerRepository
    ) {
        $this->tradeRepository = $tradeRepository;
        $this->walletRepository = $walletRepository;
        $this->offerRepository = $offerRepository;
    }

    /**
     * Start a trade
     * POST|HEAD /trade
     *
     * @param Request $request
     * @return Response
     */
    public function createTrade(Request $request) {
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

            // create order with pending state
            // Get balance for seller from bitgo
            // Get seller wallet from the table
            // Get exchange rate
            // Below should be in transaction 
                // Check validation and blocked the amount
                // change status to wait
            // If something goes wrong the mark trade as reject and throws error
            $offer = $this->offerRepository->getOfferDetailsByOfferId($request->offer_id);
            if (!$offer) {
                return $this->sendError('Offer not found', Response::HTTP_NOT_FOUND);
            }
            $wallet = $this->walletRepository->getUserWallet($offer->user_id);
            if (!$wallet) {
                return $this->sendError('Wallet not found', Response::HTTP_NOT_FOUND);
            }
            $bitgo = new BitGoSDK(env('BITGO_ACCESS_TOKEN'), $coin['id'], true);
            $bitgo->walletId = $wallet->wallet_id;
            $bitgo_wallet = $bitgo->getWallet($coin['id']);

            $market_rate = $this->walletRepository->getExchangeRateByCurrency($offer->preferredCurrency->currency_code);
            $mytime = Carbon::now();
            $tradeData = [];
            $tradeData['offer_id'] = $request->offer_id;
            $tradeData['status'] = 'Initiated';
            $tradeData['user_id'] = Auth::id();
            $tradeData['start_time'] = $mytime->toDateTimeString();
            $tradeData['currency_amount'] = $request->amount;
            $tradeData['crypto_amount'] = $market_rate * $request->amount;
            $tradeData['market_rate'] = $market_rate;
            $trade = $this->tradeRepository->start($tradeData);
            if (empty($bitgo_wallet)) {
                throw new \ErrorException('Wallet not found');
            }
            $wallet->balance = $bitgo_wallet['balance']/100000000;
            $wallet->save();
            if($trade->crypto_amount > ($wallet->balance - $wallet->locked)) {
                throw new \ErrorException('Unable to create trade due to low balance');
            }
            DB::beginTransaction();
            $wallet->locked += $trade->crypto_amount;
            $wallet->save();
            $trade->tradeStatus()->transitionTo('wait');
            DB::commit();
            // Start trade
            event(new StartTrade($trade));
            return $this->sendSuccess($trade, 'Trade started successfully');
        } catch (\Exception $e) {
            DB::rollBack(); 
            if($trade) {
                $trade->tradeStatus()->transitionTo('reject');
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
    public function cancelTrade($tradeId) {
        try {
            $trade = $this->tradeRepository->tradeDetails($coinId);
            if (!$trade) {
                return $this->sendError('Trade not found', Response::HTTP_NOT_FOUND);
            }
            $offer = $this->offerRepository->getOfferDetailsByOfferId($trade->offer_id);
            if (!$offer) {
                return $this->sendError('Offer not found', Response::HTTP_NOT_FOUND);
            }
            $wallet = $this->walletRepository->getUserWallet($offer->user_id);
            if (!$wallet) {
                return $this->sendError('Wallet not found', Response::HTTP_NOT_FOUND);
            }
            DB::beginTransaction();
            $trade->tradeStatus()->transitionTo('cancel');
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
    public function receivePayment($tradeId) {
        try {
            $trade = $this->tradeRepository->tradeDetails($coinId);
            if (!$trade) {
                return $this->sendError('Trade not found', Response::HTTP_NOT_FOUND);
            }
            $trade->tradeStatus()->transitionTo('payment_received');
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
    public function acceptPayment(Request $request) {
        try {

            $trade = $this->tradeRepository->tradeDetails($coinId);
            if (!$trade) {
                return $this->sendError('Trade not found', Response::HTTP_NOT_FOUND);
            }
            // Fetch trade details
            // Seller wallet details
            // Buyer wallet details 
            // do following things in transaction if trade status not in the cancel or reject
                // transfer bitcoin from seller to buyer
                // change trade status to done
                // update buyer and seller wallet details 


            $offer = $this->offerRepository->getOfferDetailsByOfferId($request->offer_id);
            $currency = $offer->preferredCurrency->currency_code;
            $crypto_amount = $this->walletRepository->getExchangeRate($currency, $request->amount);
            $mytime = Carbon::now();
            $tradeData = [];
            $tradeData['offer_id'] = $request->offer_id;
            $trade = $this->tradeRepository->start($tradeData);

            // Start trade
            event(new StartTrade($trade));
            
            return $this->sendSuccess($trade, 'Trade started successfully');
        } catch (\Exception $e) { 
            return $this->sendError($e->getMessage());
        }
    }



    
}