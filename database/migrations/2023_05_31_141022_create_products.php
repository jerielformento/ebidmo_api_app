<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_id')->references('id')->on('stores');
            $table->string('name', 100);
            $table->string('slug', 500);
            $table->text('details');
            $table->integer('quantity')->nullable();
            $table->foreignId('condition')->references('id')->on('product_conditions');
            $table->foreignId('category')->references('id')->on('categories');
            $table->foreignId('brand')->references('id')->on('product_brands');
            $table->foreignId('currency')->references('id')->on('currencies');
            $table->foreignId('item_location')->references('id')->on('item_locations');
            $table->integer('price')->nullable();
            $table->integer('rating')->nullable();
            $table->dateTime('created_at');
            $table->dateTime('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
