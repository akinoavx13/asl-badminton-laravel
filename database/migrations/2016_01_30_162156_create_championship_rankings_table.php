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

            $table->integer('match_played')->default(0);
            $table->integer('match_to_play')->default(0);
            $table->integer('match_won')->default(0);
            $table->integer('match_lost')->default(0);
            $table->integer('match_unplayed')->default(0);
            $table->integer('match_won_by_wo')->default(0);
            $table->integer('match_lost_by_wo')->default(0);

            $table->integer('total_difference_set')->default(0);
            $table->integer('total_difference_points')->default(0);
            $table->integer('total_points')->default(0);

            $table->integer('rank')->default(0);

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
