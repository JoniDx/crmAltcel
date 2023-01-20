<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReferencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('references', function (Blueprint $table) {
            $table->string('reference_id')->primary();
            $table->string('reference',100);
            $table->string('authorizacion')->nullable();
            $table->string('transaction_type',50);
            $table->string('status',50)->nullable();
            $table->dateTime('creation_date',0);
            $table->string('description',100);
            $table->string('error_message')->nullable();
            $table->string('order_id')->nullable();
            $table->string('payment_method',50);
            $table->decimal('amount',8,2);
            $table->string('currency',10);
            $table->string('name');
            $table->string('lastname');
            $table->string('email');
            $table->dateTime('event_date_create',0)->nullable();
            $table->dateTime('event_date_complete',0)->nullable();
            $table->string('fee_amount')->nullable();
            $table->string('fee_tax')->nullable();
            $table->string('fee_currency')->nullable();
            $table->unsignedBigInteger('referencestype_id');
            $table->unsignedBigInteger('offer_id')->nullable();
            $table->unsignedBigInteger('channel_id')->nullable();
            $table->unsignedBigInteger('number_id')->nullable();
            $table->unsignedBigInteger('rate_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('client_id')->nullable();
            $table->unsignedBigInteger('device_id')->nullable();
            $table->unsignedBigInteger('pack_id')->nullable();
            $table->timestamps();
            $table->foreign('referencestype_id')->references('id')->on('referencestypes');
            $table->foreign('offer_id')->references('id')->on('offers');
            $table->foreign('channel_id')->references('id')->on('channels');
            $table->foreign('number_id')->references('id')->on('numbers');
            $table->foreign('rate_id')->references('id')->on('rates');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('client_id')->references('id')->on('users');
            $table->foreign('device_id')->references('id')->on('devices');
            $table->foreign('pack_id')->references('id')->on('packs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('references');
    }
}
