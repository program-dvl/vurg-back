<?php

namespace App\Repositories\Trade;

use App\Models\Trade;
use App\Repositories\User\UserRepository;
use App\Repositories\Offer\OfferRepository;

class TradeRepository
{
    /**
     * @var App\Models\Trade
     */
    private $trade;

    /**
     * Create a new trade repository instance.
     *
     * @param  App\Models\Trade $state
     * @return void
     */
    public function __construct(
        Trade $trade,
        UserRepository $userRepository,
        OfferRepository $offerRepository
    ) {
        $this->trade = $trade;
        $this->userRepository = $userRepository;
        $this->offerRepository = $offerRepository;
    }

    public function start($request)
    {
        return $this->trade::create($request);
    }

    /**
     * get trade details.
     *
     * @param int $tradeId
     * @return App\Models\Trade
     */
    public function tradeDetails($tradeId)
    {
        return Trade::where("trade_id", $tradeId)->first();
    }

    /**
     * Update trade details.
     *
     * @param int $tradeId
     * @param array $dataUpdate
     * @return boolean
     */
    public function updateTradeDetails(int $tradeId, $dataUpdate)
    {
        Trade::where("trade_id", $tradeId)->update($dataUpdate);
        return true;
    }

    /**
     * get active trade details.
     *
     * @param $tradeId
     * @return App\Models\Trade
     */
    public function getActiveTradeDetails($tradeId)
    {
        $trade = $this->trade->with(['userDetails'])->find($tradeId);
        $offer = $this->offerRepository->getOfferDetailsByOfferId($trade->offer_id);
        $tradeStartTime = \Carbon\Carbon::parse($trade->start_time);
        $offerExpiryInMinute = $offer->offer_time_limit;
        $tradeExpiryTime = $tradeStartTime->addMinutes($offerExpiryInMinute);
        if ($tradeExpiryTime->lte(\Carbon\Carbon::now()) && $trade->status != 'cancel') {
            $trade->status = 'cancel';
            $trade->update();
        }
        $trade['offer_detail'] = $offer;
        $trade['counter_user_details'] = $this->userRepository->userDetails($offer->user_id);
        return $trade;
    }
}
