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

}