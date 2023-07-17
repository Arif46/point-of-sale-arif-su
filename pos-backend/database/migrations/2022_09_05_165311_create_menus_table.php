<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('module_id')->nullable();
            $table->unsignedBigInteger('service_id')->nullable();
            $table->string('name', 100);
            $table->string('url');
            $table->string('icon', 30)->nullable();
            $table->integer('sorting_order');
            $table->timestamps();

            $table->foreign('module_id')
                ->references('id')
                ->on('modules')
                ->onDelete('cascade');

            $table->foreign('service_id')
                ->references('id')
                ->on('services')
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
        Schema::dropIfExists('menus');
    }
}
