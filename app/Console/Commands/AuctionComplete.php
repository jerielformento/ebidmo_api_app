<?php

namespace App\Console\Commands;

use App\Mail\WinnerAcknowledgement;
use App\Models\Auctions;
use App\Models\CustomerBids;
use App\Models\Customers;
use App\Models\CustomersProfile;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
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
        $auctions = Auctions::with('product', 'product.store')->where('ended_at','<',Carbon::now())
            ->where('status', 1)->get();

        foreach($auctions as $auction) {
            $highest = CustomerBids::where('auction_id', $auction->id)->orderByDesc('price')->limit(1)->first();
            if($highest) {
                try {
                    Auctions::where('id', $auction->id)->update([
                        'won_by' => $highest->customer_id,
                        'status' => 4
                    ]);

                    $winner = CustomersProfile::where('customer_id', $highest->customer_id)->first(['email']);
                    $verif_token = md5($auction->id.Carbon::now()->timestamp);
                    Mail::send(new WinnerAcknowledgement($winner->email, $verif_token, $auction->product->name, $auction->product->store->name, $highest->price));

                    echo "updated ";
                } catch(Throwable $e) {
                    echo "error ";
                }
            } else {
                Auctions::where('id', $auction->id)->update([
                    'status' => 4
                ]);
            }
        }
    }
}
