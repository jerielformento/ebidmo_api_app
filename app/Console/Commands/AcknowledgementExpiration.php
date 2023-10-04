<?php

namespace App\Console\Commands;

use App\Models\AuctionWinnerAcknowledgement;
use Carbon\Carbon;
use Illuminate\Console\Command;

class AcknowledgementExpiration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'acknowledgement:expiration';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check expiration dates and change status if expired';

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
        $acknowledgements = AuctionWinnerAcknowledgement::where('ended_at', '<', Carbon::now())->where('status', 0)->get();
        foreach($acknowledgements as $acknowledge) {
            AuctionWinnerAcknowledgement::where('id', $acknowledge->id)->update([
                'expired' => 1
            ]);
        }
    }
}
