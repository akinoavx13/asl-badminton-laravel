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

            $table->boolean('simple');
            $table->boolean('double');
            $table->boolean('mixte');

            $table->boolean('corpo_man');
            $table->boolean('corpo_woman');
            $table->boolean('corpo_mixte');

            $table->boolean('t_shirt')->default(false);

            $table->integer('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');

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
