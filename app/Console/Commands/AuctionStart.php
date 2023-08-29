<?php

namespace App\Console\Commands;

use App\Models\Auctions;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Throwable;

class AuctionStart extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auction:start';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check auction start';

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
        try {
            Auctions::where('started_at','<',Carbon::now())
            ->where([
                'type' => 1,
                'status' => 2
            ])
            ->update(['status' => 1]);

            echo "updated";
        } catch(Throwable $e) {
            echo "error ";
        }
    }
}
