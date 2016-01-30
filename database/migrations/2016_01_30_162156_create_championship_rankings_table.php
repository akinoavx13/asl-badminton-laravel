<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChampionshipRankingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('championship_rankings', function (Blueprint $table)
        {
            $table->increments('id');
            $table->timestamps();

            $table->integer('match_played');
            $table->integer('match_to_play');
            $table->integer('match_won');
            $table->integer('match_lost');
            $table->integer('match_unplayed');
            $table->integer('match_won_by_wo');
            $table->integer('match_lost_by_wo');

            $table->integer('total_difference_set');
            $table->integer('total_difference_points');
            $table->integer('total_points');

            $table->integer('rank');

            $table->integer('championship_pool_id')->unsigned()->index();
            $table->foreign('championship_pool_id')->references('id')->on('championship_pools')->onDelete('cascade')
                ->onUpdate
                ('cascade');

            $table->integer('team_id')->unsigned()->index();
            $table->foreign('team_id')->references('id')->on('teams')->onDelete('cascade')
                ->onUpdate
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
        Schema::drop('championship_rankings');
    }
}
