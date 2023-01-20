<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRechargesbulksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rechargesbulks', function (Blueprint $table) {
            $table->id();
            $table->string('msisdn',20);
            $table->dateTime('effectiveDate',0)->nullable();
            $table->string('order_id',50)->nullable();
            $table->string('statusCode',10)->nullable();
            $table->string('description',255)->nullable();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('number_id');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('number_id')->references('id')->on('numbers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rechargesbulks');
    }
}
