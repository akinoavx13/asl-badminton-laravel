<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePlayersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('players', function (Blueprint $table)
        {
            $table->increments('id')->index();

            $table->enum('formula', ['leisure', 'fun', 'performance', 'corpo', 'competition']);
            $table->enum('ce_state', ['contribution_payable', 'contribution_paid']);
            $table->enum('gbc_state', ['non_applicable', 'entry_must', 'valid']);

            $table->boolean('simple')->default(false);
            $table->boolean('double')->default(false);
            $table->boolean('mixte')->default(false);

            $table->boolean('corpo_man')->default(false);
            $table->boolean('corpo_woman')->default(false);
            $table->boolean('corpo_mixte')->default(false);

            $table->boolean('t_shirt')->default(false);

            $table->boolean('search_double')->default(false);
            $table->boolean('search_mixte')->default(false);

            $table->integer('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');

            $table->integer('season_id')->unsigned()->index();
            $table->foreign('season_id')->references('id')->on('seasons')->onDelete('cascade')->onUpdate('cascade');

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
        Schema::drop('players');
    }
}
