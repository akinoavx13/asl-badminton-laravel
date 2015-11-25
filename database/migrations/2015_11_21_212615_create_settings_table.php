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

            $table->integer('leisure_price');
            $table->integer('fun_price');
            $table->integer('performance_price');
            $table->integer('corpo_price');
            $table->integer('competition_price');

            $table->integer('leisure_external_price');
            $table->integer('fun_external_price');
            $table->integer('performance_external_price');
            $table->integer('corpo_external_price');
            $table->integer('competition_external_price');

            $table->integer('t_shirt_price');

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
