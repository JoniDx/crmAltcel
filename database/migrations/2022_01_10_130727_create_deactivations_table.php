<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeactivationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deactivations', function (Blueprint $table) {
            $table->id();
            $table->string('MSISDN',15);
            $table->dateTime('effectiveDate',0);
            $table->string('order_id',30);
            $table->text('reason');
            $table->unsignedBigInteger('activation_id');
            $table->unsignedBigInteger('who_did_id');
            $table->timestamps();

            $table->foreign('activation_id')->references('id')->on('activations');
            $table->foreign('who_did_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('deactivations');
    }
}
