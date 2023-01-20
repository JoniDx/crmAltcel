<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewFieldsToAnothercompanies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('anothercompanies', function (Blueprint $table) {
            $table->text('comments')->nullable();
            $table->boolean('hunted')->default(false);
            $table->unsignedBigInteger('taken_by')->nullable();
            $table->dateTime('taken_at',0)->nullable();

            $table->foreign('taken_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('anothercompanies', function (Blueprint $table) {
            //
        });
    }
}
