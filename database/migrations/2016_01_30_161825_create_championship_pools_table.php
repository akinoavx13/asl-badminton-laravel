<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChampionshipPoolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('championship_pools', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            $table->integer('number');
            $table->enum('type', ['simple', 'simple_man', 'simple_woman', 'double', 'double_man', 'double_woman',
            'mixte']);

            $table->integer('period_id')->unsigned()->index();
            $table->foreign('period_id')->references('id')->on('periods')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('championship_pools');
    }
}
