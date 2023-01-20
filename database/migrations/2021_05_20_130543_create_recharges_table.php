<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRechargesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recharges', function (Blueprint $table) {
            $table->id();
            $table->string('reference_id');
            $table->unsignedBigInteger('number_id');
            $table->unsignedBigInteger('rate_id');
            $table->date('date_start');
            $table->date('date_expiration');
            $table->string('status');
            $table->timestamps();
            $table->foreign('reference_id')->references('reference_id')->on('references');
            $table->foreign('number_id')->references('id')->on('numbers');
            $table->foreign('rate_id')->references('id')->on('rates');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('recharges');
    }
}
