<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstalationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('instalations', function (Blueprint $table) {
            $table->id();
            $table->string('no_serie_antena',100)->nullable();
            $table->string('mac_address_antena',100)->nullable();
            $table->string('model_antena',50)->nullable();
            $table->string('no_serie_router',100)->nullable();
            $table->string('mac_address_router',100)->nullable();
            $table->string('model_router',50)->nullable();
            $table->string('ip_address_antena',50)->nullable();
            $table->string('lat')->nullable();
            $table->string('lng')->nullable();
            $table->string('address',100);
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('pack_id');
            $table->unsignedBigInteger('radiobase_id')->nullable();
            $table->unsignedBigInteger('who_did_id');
            $table->float('amount',8,2)->nullable();
            $table->float('amount_install',8,2)->nullable();
            $table->float('amount_total',8,2)->nullable();
            $table->date('date_instalation',0);
            $table->unsignedBigInteger('clientson_id')->nullable();
            $table->timestamps();
            $table->foreign('client_id')->references('id')->on('users');
            $table->foreign('pack_id')->references('id')->on('packs');
            $table->foreign('radiobase_id')->references('id')->on('radiobases');
            $table->foreign('who_did_id')->references('id')->on('users');
            $table->foreign('clientson_id')->references('id')->on('clientssons');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('instalations');
    }
}
