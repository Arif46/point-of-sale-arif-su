<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCityCorporationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('city_corporations', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->index();
            $table->unsignedBigInteger('division_id')->index();
            $table->unsignedBigInteger('district_id')->index();
            $table->unsignedInteger('code')->unique();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->integer('status')->default(1)->comment('1=active, 2=inactive');
            $table->timestamps();

            $table->foreign('division_id')
                ->references('id')
                ->on('divisions')
                ->onDelete('cascade');

            $table->foreign('district_id')
                ->references('id')
                ->on('districts')
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
        Schema::dropIfExists('city_corporations');
    }
}
