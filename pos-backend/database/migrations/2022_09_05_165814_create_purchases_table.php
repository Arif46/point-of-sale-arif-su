<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('shop_id');
            $table->string('invoice_id');
            $table->unsignedBigInteger('supplier_id');
            $table->unsignedBigInteger('chalan_id')->nullable();
            $table->double('total_quantity');
            $table->double('sub_total_price', 10,2)->default(0);
            $table->double('discount', 10, 2)->default(0);
            $table->double('total_price', 10, 2)->default(0);
            $table->double('paid_amount', 10, 2)->default(0);
            $table->date('date');
            $table->string('note')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();

            $table->foreign('shop_id')->references('id')->on('shops');
            $table->foreign('supplier_id')->references('id')->on('suppliers');
            $table->foreign('chalan_id')->references('id')->on('chalans');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchases');
    }
}
