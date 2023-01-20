<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSimexternalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('simexternals', function (Blueprint $table) {
            $table->id();
            $table->string('sim_altcel',15);
            $table->unsignedBigInteger('activation_id');
            $table->unsignedBigInteger('client_id');
            $table->timestamps();
            $table->foreign('activation_id')->references('id')->on('activations');
            $table->foreign('client_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('simexternals');
    }
}
