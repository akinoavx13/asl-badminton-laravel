<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddInfoToMatch extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('matches', function (Blueprint $table) {
            $table->boolean('display')->default(true);

            $table->renameColumn('info_winner', 'info_looser_first_team');
            $table->renameColumn('info_looser', 'info_looser_second_team');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('matches', function (Blueprint $table) {
            $table->dropColumn('display');

            $table->renameColumn('info_looser_first_team', 'info_winner');
            $table->renameColumn('info_looser_second_team', 'info_looser');
        });
    }
}
