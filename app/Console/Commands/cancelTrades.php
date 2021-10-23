<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Trade;
use App\Models\Offers;

class cancelTrades extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cancel:trades';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command cancel the trades which crossed the expiry time and not finished';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $count = 0;
        $trades = Trade::where('status', '!=','cancel')->get();
        foreach ($trades as $key => $trade) {
            $offer = Offers::find($trade->offer_id);
            $tradeStartTime = \Carbon\Carbon::parse($trade->start_time);
            $offerExpiryInMinute = $offer->offer_time_limit;
            $tradeExpiryTime = $tradeStartTime->addMinutes($offerExpiryInMinute);
            if ($tradeExpiryTime->lte(\Carbon\Carbon::now()) && $trade->status != 'cancel') {
                $trade->status = 'cancel';
                $trade->update();
                $count++;
            }
        }
        $this->info('Total '. $count. ' trades moved to cancelled status');
    }
}
