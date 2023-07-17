<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChalanDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chalan_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('chalan_id');
            $table->unsignedBigInteger('product_id');
            $table->double('quantity')->default(0);
            $table->double('unit_price')->default(0);
            $table->double('total_price')->default(0);
            $table->timestamps();

            $table->foreign('chalan_id')->references('id')->on('chalans');
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
        Schema::dropIfExists('chalan_details');
    }
}
