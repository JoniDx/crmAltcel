<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->string('offerID',50);
            $table->string('name');
            $table->text('description');
            $table->string('product_altan')->nullable();
            $table->string('action');
            $table->string('product',20);
            $table->string('recurrency',5);
            $table->float('price_s_iva',8,2);
            $table->float('price_c_iva',8,2);
            $table->float('price_sale',8,2);
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
        Schema::dropIfExists('offers');
    }
}
