<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCorpo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        DB::statement("ALTER TABLE players MODIFY COLUMN gbc_state ENUM('non_applicable', 'entry_must', 'valid', 'licence')");
        Schema::table('players', function (Blueprint $table) {
            $table->enum('certificate', ['non_applicable', 'questionnaire', 'certificate']);
            $table->string('corpo_comment');
            $table->integer('corpo_team');
            $table->integer('corpo_team_mixte');
            $table->enum('polo_delivered', ['non_applicable','to_order','to_deliver', 'done']);
        });
            
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        DB::statement("ALTER TABLE players MODIFY COLUMN gbc_state ENUM('non_applicable', 'entry_must', 'valid')");
        Schema::table('players', function (Blueprint $table) {
            $table->dropColumn('certificate');
            $table->dropColumn('corpo_comment');
            $table->dropColumn('corpo_team');
            $table->dropColumn('corpo_team_mixte');
            $table->dropColumn('polo_delivered');
        });
    }
}
