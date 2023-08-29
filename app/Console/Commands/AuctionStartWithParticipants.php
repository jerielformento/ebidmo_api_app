<?php

namespace App\Console\Commands;

use App\Models\Auctions;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Throwable;

class AuctionStartWithParticipants extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auction:start_participants';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
            $auction = Auctions::withCount('participants')->where('started_at','<',Carbon::now())
            ->where([
                'type' => 2,
                'status' => 2
            ])
            ->first();

            $status = ((int)$auction->participants_count === (int)$auction->min_participants) ? 1 : 3;

            Auctions::find($auction->id)->update([
                'status' => $status
            ]);
        } catch(Throwable $e) {
            echo "error ";
        }
    }
}
