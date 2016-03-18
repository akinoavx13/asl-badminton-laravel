<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matches', function (Blueprint $table)
        {
            $table->increments('id');
            $table->timestamps();

            $table->integer('matches_number_in_table')->unsigned();

            $table->integer('first_team_id')->unsigned()->nullable();
            $table->integer('second_team_id')->unsigned()->nullable();

            $table->integer('table_rank')->unsigned();

            $table->integer('table_id')->unsigned();
            $table->foreign('table_id')->references('id')->on('tables')->onDelete('cascade')->onUpdate
            ('cascade');

            $table->integer('next_match_winner_id')->unsigned()->nullable();

            $table->integer('next_match_looser_id')->unsigned()->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('matches');
    }
}
