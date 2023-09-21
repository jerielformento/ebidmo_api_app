<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShipmentTransactions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipment_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('acknowledgement_token', 100);
            $table->text('full_name');
            $table->text('address');
            $table->string('contact', 10);
            $table->foreignId('courier')->references('id')->on('couriers');
            $table->foreignId('status')->references('id')->on('shipment_status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shipment_transactions');
    }
}
