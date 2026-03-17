<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTypeToRopesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ropes', function (Blueprint $table) {
            $table->string('type')->default('BG80')->after('tension');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ropes', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
}
