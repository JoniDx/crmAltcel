<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackspoliticsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packspolitics', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->bigInteger('porcent');
            $table->unsignedBigInteger('pack_id');
            $table->timestamps();
            $table->foreign('pack_id')->references('id')->on('packs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('packspolitics');
    }
}
