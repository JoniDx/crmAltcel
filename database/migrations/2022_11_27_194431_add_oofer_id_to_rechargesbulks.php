<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOoferIdToRechargesbulks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rechargesbulks', function (Blueprint $table) {
            $table->unsignedBigInteger('offer_id')->nullable()->after('number_id');
            $table->foreign('offer_id')->references('id')->on('offers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rechargesbulks', function (Blueprint $table) {
            //
        });
    }
}
