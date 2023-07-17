<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCentralStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('central_stocks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('shop_id');
            $table->unsignedBigInteger('product_id');
            $table->double('quantity', 10, 2)->default(0);
            $table->timestamps();

            $table->foreign('shop_id')->references('id')->on('shops');
            $table->foreign('product_id')->references('id')->on('products');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('central_stocks');
    }
}
