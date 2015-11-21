<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table)
        {
            $table->increments('id')->index();
            $table->string('cestas_sport_email');
            $table->string('web_site_email');
            $table->string('web_site_name');
            $table->string('cc_email');
            $table->boolean('can_buy_t_shirt');
            $table->boolean('can_enroll');
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
        Schema::drop('settings');
    }
}
