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
            $table->foreign('first_team_id')->references('id')->on('teams')->onDelete('cascade')->onUpdate
            ('cascade');

            $table->integer('second_team_id')->unsigned()->nullable();
            $table->foreign('second_team_id')->references('id')->on('teams')->onDelete('cascade')->onUpdate
            ('cascade');

            $table->integer('series_rank')->unsigned();

            $table->integer('series_id')->unsigned();
            $table->foreign('series_id')->references('id')->on('series')->onDelete('cascade')->onUpdate
            ('cascade');

            $table->integer('next_match_winner_id')->unsigned()->nullable();
            $table->foreign('next_match_winner_id')->references('id')->on('matches')->onDelete('cascade')->onUpdate
            ('cascade');

            $table->integer('next_match_looser_id')->unsigned()->nullable();
            $table->foreign('next_match_looser_id')->references('id')->on('matches')->onDelete('cascade')->onUpdate
            ('cascade');
            
            $table->integer('team_number_winner')->unsigned()->nullable();
            $table->integer('team_number_looser')->unsigned()->nullable();

            $table->integer('score_id')->unsigned()->nullable();
            $table->foreign('score_id')->references('id')->on('scores')->onDelete('cascade')->onUpdate
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
        Schema::drop('matches');
    }
}
