<?php

namespace App\Repositories\Trade;

use App\Models\Trade;

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
        Trade $trade
    ) {
        $this->trade = $trade;
    }

    public function start($request) {
        return $this->trade::create($request);
    }

    /**
     * get trade details.
     *
     * @param int $tradeId
     * @return App\Models\Trade
     */
    public function tradeDetails(int $tradeId): Trade
    {
        return $this->trade->find($tradeId);
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
        Trade::where("id", $tradeId)->update($dataUpdate);
        return true;
    }
}