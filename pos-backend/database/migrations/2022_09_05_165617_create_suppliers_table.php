<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuppliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('shop_id');
            $table->unsignedInteger('code')->unique();
            $table->string('name', 100)->index();
            $table->string('mobile', 20)->index()->unique();
            $table->string('email', 50)->index()->unique()->nullable();
            $table->string('vat_reg_no')->nullable();
            $table->string('address')->nullable();
            $table->text('note')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();

            
            $table->foreign('shop_id')
            ->references('id')
            ->on('shops')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('suppliers');
    }
}
