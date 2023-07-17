<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('shop_id');
            $table->string('name', 100)->index();
            $table->unsignedInteger('code')->unique();
            $table->unsignedBigInteger('supplier_id');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('brand_id');
            $table->unsignedBigInteger('unit_id');
            $table->unsignedBigInteger('size_id');
            $table->unsignedBigInteger('model_id');
            $table->unsignedBigInteger('color_id');
            $table->double('purchase_price', 10, 2)->default(0);
            $table->double('sale_price', 10, 2)->default(0);
            $table->double('opening_stock', 10, 2)->default(0);
            $table->unsignedTinyInteger('is_vat')->comment('1=Yes, 2=No')->default(2);
            $table->date('expired_date')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();

            $table->foreign('shop_id')->references('id')->on('shops')->onDelete('cascade');
            $table->foreign('supplier_id')->references('id')->on('suppliers');
            $table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('brand_id')->references('id')->on('brands');
            $table->foreign('unit_id')->references('id')->on('units');
            $table->foreign('size_id')->references('id')->on('sizes');
            $table->foreign('color_id')->references('id')->on('colors');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
