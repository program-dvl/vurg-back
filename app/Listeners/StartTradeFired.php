<?php

namespace App\Listeners;

use App\Events\StartTrade;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class StartTradeFired
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  StartTrade  $event
     * @return void
     */
    public function handle(StartTrade $event)
    {
        //
    }
}
