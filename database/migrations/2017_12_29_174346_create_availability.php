<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAvailability extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('availability', function (Blueprint $table) {
          $table->increments('id')->index();
          $table->integer('user_id')->unsigned()->index();
          $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
          $table->date('date');
          $table->integer('time_slot_id')->unsigned()->index();
          $table->foreign('time_slot_id')->references('id')->on('time_slots')->onDelete('cascade')->onUpdate('cascade');
          $table->boolean('available');
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
        Schema::drop('availability');
    }
}
