<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('username', 45);
            $table->string('password', 100);
            $table->foreignId('role')->references('id')->on('user_roles');
            $table->foreignId('auth_type')->references('id')->on('user_auth_types');
            $table->integer('is_verified');
            $table->rememberToken();
            $table->dateTime('registered_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
    }
}
