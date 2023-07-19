<?php

namespace App\Console\Commands;

use App\Models\Bids;
use App\Models\CustomerBids;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Throwable;

class AuctionComplete extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auction:complete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check auction complete to declare winner';

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
        $bids = Bids::where('ended_at','<',Carbon::now())
            ->where('status', 1)->get();

        foreach($bids as $bid) {
            $highest = CustomerBids::where('bid_id', $bid->id)->orderByDesc('price')->limit(1)->first();
            if($highest) {
                try {
                    Bids::where('id', $bid->id)->update([
                        'won_by' => $highest->customer_id,
                        'status' => 0
                    ]);

                    echo "updated ";
                } catch(Throwable $e) {
                    echo "error ";
                }
            } else {
                Bids::where('id', $bid->id)->update([
                    'status' => 0
                ]);
            }
        }
    }
}
