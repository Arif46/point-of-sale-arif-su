<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->index();
            $table->string('mobile', 20)->index()->unique();
            $table->string('email')->index()->nullable()->unique();
            $table->unsignedInteger('type')->comment('1=Admin, 2=Shop User')->default(2);
            $table->unsignedInteger('software_access')->comment('1=Yes, 2=No')->default(2);
            $table->unsignedBigInteger('role_id');
            $table->unsignedBigInteger('shop_id')->nullable();
            $table->date('dob');
            $table->string('nid', 30)->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('role_id')
                ->references('id')
                ->on('roles')
                ->onDelete('cascade');

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
        Schema::dropIfExists('users');
    }
}
