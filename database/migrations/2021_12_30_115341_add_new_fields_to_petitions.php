<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewFieldsToPetitions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::table('petitions', function (Blueprint $table) {
        //     $table->unsignedBigInteger('number_id')->nullable();
        //     $table->unsignedBigInteger('device_id')->nullable();
        //     $table->date('date_to_activation')->nullable();
        //     $table->string('lat_hbb',50)->nullable();
        //     $table->string('lng_hbb',50)->nullable();

        //     $table->foreign('company_id')->references('id')->on('companies');
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('petitions', function (Blueprint $table) {
            //
        });
    }
}
