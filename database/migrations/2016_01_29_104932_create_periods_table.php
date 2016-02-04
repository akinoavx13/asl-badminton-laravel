<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePeriodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('periods', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            $table->date('start');
            $table->date('end');

            $table->integer('season_id')->unsigned()->index();
            $table->foreign('season_id')->references('id')->on('seasons')->onDelete('cascade')->onUpdate('cascade');

            $table->enum('type', ['championship', 'tournament']);

            $table->boolean('championship_simple_woman');
            $table->boolean('championship_double_woman');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('periods');
    }
}
