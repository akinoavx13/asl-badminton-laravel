<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scores', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            $table->integer('first_set_first_team')->default(0);
            $table->integer('first_set_second_team')->default(0);

            $table->integer('second_set_first_team')->default(0);
            $table->integer('second_set_second_team')->default(0);

            $table->integer('third_set_first_team')->default(0);
            $table->integer('third_set_second_team')->default(0);

            $table->boolean('display')->default(false);

            $table->integer('first_team_id')->unsigned()->index();
            $table->foreign('first_team_id')->references('id')->on('teams')->onDelete('cascade')->onUpdate('cascade');

            $table->integer('second_team_id')->unsigned()->index();
            $table->foreign('second_team_id')->references('id')->on('teams')->onDelete('cascade')->onUpdate('cascade');

            $table->boolean('my_wo')->default(false);
            $table->boolean('his_wo')->default(false);
            $table->boolean('unplayed')->default(true);

            $table->boolean('first_team_win')->default(false);
            $table->boolean('second_team_win')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('scores');
    }
}
