<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEthernetpaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ethernetpays', function (Blueprint $table) {
            $table->id();
            $table->date('date_pay',0);
            $table->date('date_pay_limit',0);
            $table->string('status');
            $table->unsignedBigInteger('instalation_id');
            $table->string('reference_id')->nullable();
            $table->float('amount',8,2)->nullable();
            $table->float('amount_received',8,2)->nullable();
            $table->string('type_pay',25)->nullable();
            $table->string('folio_pay',70)->nullable();
            $table->timestamps();
            $table->foreign('instalation_id')->references('id')->on('instalations');
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
        Schema::dropIfExists('ethernetpays');
    }
}
