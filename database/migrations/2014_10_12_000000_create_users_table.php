<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

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
            $table->increments('id')->index();
            $table->string('name', 60);
            $table->string('forname', 60);
            $table->string('email')->unique();
            $table->date('birthday');
            $table->string('tshirt_size', 10);
            $table->string('gender', 10);
            $table->string('address')->nullable();
            $table->string('phone', 60)->nullable();
            $table->string('license', 60)->nullable();
            $table->boolean('active')->default(true);
            $table->string('state', 60)->default('active');
            $table->string('lectra_relationship', 60);
            $table->boolean('newsletter')->default(false);
            $table->boolean('avatar')->default(false);
            $table->string('role', 10);
            $table->boolean('first_connect')->default(true);
            $table->string('password', 60);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
