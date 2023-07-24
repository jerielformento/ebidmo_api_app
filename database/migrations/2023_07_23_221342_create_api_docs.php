<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApiDocs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('api_docs', function (Blueprint $table) {
            $table->id();
            $table->string('router');
            $table->string('method');
            $table->string('uri');
            $table->string('name');
            $table->string('headers');
            $table->text('payload');
            $table->text('response');
            $table->string('auth_type');
            $table->text('description');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('api_docs');
    }
}
