<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnothercompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('anothercompanies', function (Blueprint $table) {
            $table->id();
            $table->string('paterno',100)->nullable();
            $table->string('materno',100)->nullable();
            $table->string('nombres',100)->nullable();
            $table->string('telefono',20)->nullable();
            $table->string('edad',5)->nullable();
            $table->string('mes_nacimiento',5)->nullable();
            $table->text('domicilio')->nullable();
            $table->string('cp',10)->nullable();
            $table->string('municipio',255)->nullable();
            $table->string('ciudad',255)->nullable();
            $table->string('status',20)->nullable();
            $table->unsignedBigInteger('contacted_by')->nullable();
            $table->timestamps();

            $table->foreign('contacted_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('anothercompanies');
    }
}
