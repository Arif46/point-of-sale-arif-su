<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockOutDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_out_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('stok_out_id');
            $table->unsignedBigInteger('product_id');
            $table->double('quantity', 10, 2)->default(0);
            $table->date('date');
            $table->timestamps();
            $table->foreign('stok_out_id')->references('id')->on('stock_outs');
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
        Schema::dropIfExists('stock_out_details');
    }
}
