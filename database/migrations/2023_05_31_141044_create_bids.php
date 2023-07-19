<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBids extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bids', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->references('id')->on('products');
            $table->integer('min_price');
            $table->integer('buy_now_price')->nullable();
            $table->integer('currency');
            $table->dateTime('started_at');
            $table->dateTime('ended_at');
            $table->integer('increment_by');
            $table->integer('status');
            $table->integer('min_participants');
            $table->foreignId('won_by')->nullable()->references('id')->on('customers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bids');
    }
}
