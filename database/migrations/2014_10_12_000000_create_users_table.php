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
            $table->enum('tshirt_size', ['XXS', 'XS', 'S', 'M', 'L', 'XL', 'XLL']);
            $table->enum('gender', ['man', 'woman']);
            $table->string('address')->nullable();
            $table->string('phone', 60)->nullable();
            $table->string('license', 60)->nullable();
            $table->boolean('active')->default(true);
            $table->enum('state', ['active', 'holiday', 'hurt', 'inactive'])->default('active');
            $table->date('ending_holiday');
            $table->date('ending_injury');
            $table->enum('lectra_relationship',
                ['lectra', 'child', 'conjoint', 'external', 'trainee', 'subcontractor']);
            $table->boolean('newsletter')->default(false);
            $table->boolean('avatar')->default(false);
            $table->enum('role', ['user', 'admin']);
            $table->boolean('first_connect')->default(true);
            $table->string('password', 60);
            $table->string('token_first_connection');
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
