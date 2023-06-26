<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerBids extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_bids', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bid_id')->references('id')->on('bids');
            $table->foreignId('customer_id')->references('id')->on('customers');
            $table->integer('price');
            $table->dateTime('bidded_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_bids');
    }
}
