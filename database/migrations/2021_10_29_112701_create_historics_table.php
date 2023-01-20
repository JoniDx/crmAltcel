<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistoricsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('historics', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('oldMSISDN',15);
        //     $table->dateTime('date_change',0);
        //     $table->string('order_id',15);
        //     $table->unsignedBigInteger('number_id');
        //     $table->timestamps();

        //     $table->foreign('number_id')->references('id')->on('numbers');
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('historics');
    }
}
