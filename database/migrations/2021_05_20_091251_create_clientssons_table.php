<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientssonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientssons', function (Blueprint $table) {
            $table->id();
            $table->string('name',90)->nullable();
            $table->string('lastname',90)->nullable();
            $table->string('rfc',20)->nullable();
            $table->date('date_born',0)->nullable();
            $table->string('address',150)->nullable();
            $table->string('email',60)->nullable();
            $table->string('ine_code',20)->nullable();
            $table->string('cellphone',20)->nullable();
            $table->string('type_person',15)->nullable();
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
        Schema::dropIfExists('clientssons');
    }
}
