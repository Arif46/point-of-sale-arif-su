<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shops', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->index();
            $table->string('mobile', 20)->index();
            $table->string('owner_name', 100)->index();
            $table->string('owner_mobile', 20)->index();
            $table->unsignedInteger('area_type_id')->comment('1=City Corporation, 2=Paurashava, 3=Union');
            $table->unsignedBigInteger('division_id')->index();
            $table->unsignedBigInteger('district_id')->index();
            $table->unsignedBigInteger('city_corporation_id')->default(0);
            $table->unsignedBigInteger('upazila_id')->default(0);
            $table->unsignedBigInteger('paurashava_id')->default(0);
            $table->unsignedBigInteger('union_id')->default(0);
            $table->unsignedBigInteger('ward_id')->default(0);
            $table->string('address_details')->nullable();
            $table->text('note')->nullable();
            $table->date('next_due')->nullable();
            $table->unsignedTinyInteger('status')->comment('1=On, 2=Off');
            $table->string('logo', 100)->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();

            $table->foreign('division_id')
                ->references('id')
                ->on('divisions')
                ->onDelete('cascade');
                
            $table->foreign('district_id')
                ->references('id')
                ->on('districts')
                ->onDelete('cascade');
                
            $table->foreign('city_corporation_id')
                ->references('id')
                ->on('city_corporations')
                ->onDelete('cascade');

            $table->foreign('paurashava_id')
                ->references('id')
                ->on('paurashavas')
                ->onDelete('cascade');

            $table->foreign('upazila_id')
                ->references('id')
                ->on('upazillas')
                ->onDelete('cascade');

            $table->foreign('union_id')
                ->references('id')
                ->on('unions')
                ->onDelete('cascade');

            $table->foreign('ward_id')
                ->references('id')
                ->on('wards')
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
        Schema::dropIfExists('shops');
    }
}
