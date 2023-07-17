<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockInDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_in_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('stock_in_id');
            $table->unsignedBigInteger('product_id');
            $table->double('quantity', 10, 2)->default(0);
            $table->double('purchase_price', 10, 2)->default(0);
            $table->double('sale_price', 10, 2)->default(0);
            $table->timestamps();

            $table->foreign('stock_in_id')->references('id')->on('stock_ins');
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
        Schema::dropIfExists('stock_in_details');
    }
}
