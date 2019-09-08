<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTension extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('ropes', function (Blueprint $table) {
            $table->float('tension')->default(0.0);
            $table->string('comment');            
        });

        Schema::table('users', function (Blueprint $table) {
            $table->float('tension')->default(0.0);            
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
        Schema::table('ropes', function (Blueprint $table) {
            $table->dropColumn('tension');
            $table->dropColumn('comment');            
        });
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('tension');            
        });
    }
}
