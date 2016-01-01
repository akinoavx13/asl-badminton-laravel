<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminsReservationsTimeSlotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins_reservations_time_slots', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            $table->integer('admins_reservations_id')->unsigned()->index();
            $table->foreign('admins_reservations_id')->references('id')->on('admins_reservations')->onDelete
            ('cascade')->onUpdate('cascade');

            $table->integer('time_slots_id')->unsigned()->index();
            $table->foreign('time_slots_id')->references('id')->on('time_slots')->onDelete('cascade')->onUpdate
            ('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('admins_reservations_time_slots');
    }
}
