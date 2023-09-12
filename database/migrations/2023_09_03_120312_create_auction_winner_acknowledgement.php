<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuctionWinnerAcknowledgement extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auction_winner_acknowledgement', function (Blueprint $table) {
            $table->id();
            $table->foreignId('auction_id')->references('id')->on('auctions');
            $table->foreignId('customer_id')->references('id')->on('customers');
            $table->string('url_token', 255);
            $table->integer('status');
            $table->dateTime('started_at');
            $table->dateTime('ended_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('auction_winner_acknowledgement');
    }
}
