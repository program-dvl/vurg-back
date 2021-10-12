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

    public function start(Request $request) {
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
            $currency = $offer->preferredCurrency->currency_code;
            $crypto_amount = $this->walletRepository->getExchangeRate($currency, $request->amount);
            $mytime = Carbon::now();
            $tradeData = [];
            $tradeData['offer_id'] = $request->offer_id;
            $tradeData['status'] = 'Initiated';
            $tradeData['user_id'] = Auth::id();
            $tradeData['start_time'] = $mytime->toDateTimeString();
            $tradeData['currency_amount'] = $request->amount;
            $tradeData['crypto_amount'] = $crypto_amount;
            $trade = $this->tradeRepository->start($tradeData);

            // Start trade
            event(new StartTrade($trade));
            
            return $this->sendSuccess($trade, 'Trade started successfully');
        } catch (\Exception $e) { 
            return $this->sendError($e->getMessage());
        }
    }
}