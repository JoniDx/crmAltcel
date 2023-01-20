<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /* Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('number_id');
            $table->unsignedBigInteger('offer_id');
            $table->unsignedBigInteger('rate_id');
            $table->unsignedBigInteger('who_did_id');
            $table->timestamps();

            $table->foreign('number_id')->references('id')->on('numbers');
            $table->foreign('offer_id')->references('id')->on('offers');
            $table->foreign('rate_id')->references('id')->on('rates');
            $table->foreign('who_did_id')->references('id')->on('users');
        }); */
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::dropIfExists('purchases');
    }
}
