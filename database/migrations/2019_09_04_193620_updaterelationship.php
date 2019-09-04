<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Updaterelationship extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        //Schema::table('users', function (Blueprint $table) {
        //    $table->enum('lectra_relationship',
        //        ['lectra', 'child', 'conjoint', 'external', 'trainee', 'subcontractor', 'partnership']);
        //});
        DB::statement("ALTER TABLE users MODIFY COLUMN lectra_relationship ENUM('lectra', 'child', 'conjoint', 'external', 'trainee', 'subcontractor', 'partnership')");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        //Schema::table('users', function (Blueprint $table) {
        //    $table->enum('lectra_relationship',
        //        ['lectra', 'child', 'conjoint', 'external', 'trainee', 'subcontractor']);
        //});
        DB::statement("ALTER TABLE users MODIFY COLUMN lectra_relationship ENUM('lectra', 'child', 'conjoint', 'external', 'trainee', 'subcontractor')");
    }
}
