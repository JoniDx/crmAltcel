<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pays', function (Blueprint $table) {
            $table->id();
            $table->date('date_pay',0);
            $table->date('date_pay_limit',0);
            $table->string('status');
            $table->unsignedBigInteger('activation_id');
            $table->string('reference_id')->nullable();
            $table->float('amount',8,2)->nullable();
            $table->float('amount_received',8,2)->nullable();
            $table->string('type_pay',25)->nullable();
            $table->string('folio_pay',70)->nullable();
            $table->timestamps();
            $table->foreign('activation_id')->references('id')->on('activations');
            $table->foreign('reference_id')->references('reference_id')->on('references');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pays');
    }
}
