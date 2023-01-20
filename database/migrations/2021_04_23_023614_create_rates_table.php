<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rates', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->float('price',8,2);
            $table->string('image')->nullable();
            $table->bigInteger('recurrency');
            $table->unsignedBigInteger('alta_offer_id');
            $table->unsignedBigInteger('multi_offer_id');
            $table->bigInteger('altcel_pack_id')->nullable();
            $table->string('status')->default('activo')->nullable();
            $table->timestamps();
            $table->foreign('alta_offer_id')->references('id')->on('offers');
            $table->foreign('multi_offer_id')->references('id')->on('offers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rates');
    }
}
