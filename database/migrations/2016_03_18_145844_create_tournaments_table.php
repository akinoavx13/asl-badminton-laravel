<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTournamentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tournaments', function (Blueprint $table)
        {
            $table->increments('id');
            $table->timestamps();

            $table->date('start');
            $table->date('end');
            $table->integer('table_number')->unsigned();
            $table->string('name');

            $table->integer('season_id')->unsigned();
            $table->foreign('season_id')->references('id')->on('seasons')->onDelete('cascade')->onUpdate
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
        Schema::drop('tournaments');
    }
}
