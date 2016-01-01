<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminsReservationsCourtsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins_reservations_courts', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            $table->integer('admins_reservation_id')->unsigned()->index();
            $table->foreign('admins_reservation_id')->references('id')->on('admins_reservations')->onDelete('cascade')->onUpdate('cascade');

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
        Schema::drop('admins_reservations_courts');
    }
}
