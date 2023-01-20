<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNumbersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('numbers', function (Blueprint $table) {
            $table->id();
            $table->string('be_id',5);
            $table->string('imsi',30);
            $table->string('imsi_rb1',30);
            $table->string('imsi_rb2',30);
            $table->string('icc_id',30);
            $table->string('MSISDN');
            $table->string('pin',10);
            $table->string('puk',10);
            $table->string('serie',10);
            $table->string('producto',5);
            $table->string('status')->default('available');
            $table->string('traffic_outbound')->default('activo');
            $table->string('traffic_outbound_incoming')->default('activo');
            $table->string('status_altan')->default('activo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('numbers');
    }
}
