<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminsReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins_reservations', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            $table->date('start');
            $table->date('end');

            $table->string('title');
            $table->text('comment')->nullable();

            $table->boolean('recurring')->default(false);
            $table->string('day')->nullable();

            $table->integer('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('admins_reservations');
    }
}
