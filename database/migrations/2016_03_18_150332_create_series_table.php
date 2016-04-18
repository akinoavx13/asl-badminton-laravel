<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSeriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('series', function (Blueprint $table)
        {
            $table->increments('id');
            $table->timestamps();

            $table->enum('category', ['S', 'SH', 'SD', 'D', 'DD', 'DH', 'M']);
            $table->integer('display_order')->unsigned();
            $table->string('name');

            $table->integer('number_matches_rank_1')->unsigned();
            $table->integer('number_rank')->unsigned();

            $table->integer('tournament_id')->unsigned();
            $table->foreign('tournament_id')->references('id')->on('tournaments')->onDelete('cascade')->onUpdate
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
        Schema::drop('series');
    }
}
