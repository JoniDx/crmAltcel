<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->dateTime('date_install_init',0);
            $table->dateTime('date_install_final',0);
            $table->string('address');
            $table->string('reference_address');
            $table->string('name',50);
            $table->string('lastname',50);
            $table->string('email',50);
            $table->string('cellphone');
            $table->string('status');
            $table->unsignedBigInteger('pack_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('who_did_id');
            $table->unsignedBigInteger('instalation_id')->nullable();
            $table->timestamps();
            $table->foreign('pack_id')->references('id')->on('packs');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('who_did_id')->references('id')->on('users');
            $table->foreign('instalation_id')->references('id')->on('instalations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('schedules');
    }
}
