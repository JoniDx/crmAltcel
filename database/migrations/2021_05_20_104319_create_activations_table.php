<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('numbers_id');
            $table->unsignedBigInteger('devices_id')->nullable();
            $table->unsignedBigInteger('who_did_id');
            $table->unsignedBigInteger('offer_id');
            $table->unsignedBigInteger('rate_id')->nullable();
            $table->unsignedBigInteger('dependence_id')->nullable();
            $table->float('amount',8,2);
            $table->date('date_activation');
            $table->unsignedBigInteger('clientson_id')->nullable();
            $table->string('lat_hbb',30)->nullable();
            $table->string('lng_hbb',30)->nullable();
            $table->timestamps();
            $table->foreign('client_id')->references('id')->on('users');
            $table->foreign('numbers_id')->references('id')->on('numbers');
            $table->foreign('devices_id')->references('id')->on('devices');
            $table->foreign('who_did_id')->references('id')->on('users');
            $table->foreign('offer_id')->references('id')->on('offers');
            $table->foreign('rate_id')->references('id')->on('rates');
            $table->foreign('clientson_id')->references('id')->on('clientssons');
            $table->foreign('dependence_id')->references('id')->on('dependences');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('activations');
    }
}
