<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlayersReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('players_reservations', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            $table->date('date');

            $table->integer('first_team')->unsigned()->index();
            $table->integer('second_team')->unsigned()->index();

            $table->integer('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');

            $table->integer('time_slot_id')->unsigned()->index();
            $table->foreign('time_slot_id')->references('id')->on('time_slots')->onDelete('cascade')->onUpdate('cascade');

            $table->integer('court_id')->unsigned()->index();
            $table->foreign('court_id')->references('id')->on('courts')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('players_reservations');
    }
}
