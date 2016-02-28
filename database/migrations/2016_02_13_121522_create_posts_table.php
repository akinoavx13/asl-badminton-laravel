<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');

            $table->integer('score_id')->unsigned()->nullable();
            $table->foreign('score_id')->references('id')->on('scores')->onDelete('cascade')->onUpdate('cascade');

            $table->integer('actuality_id')->unsigned()->nullable();
            $table->foreign('actuality_id')->references('id')->on('actualities')->onDelete('cascade')->onUpdate
            ('cascade');

            $table->boolean('photo')->default(false);

            $table->text('content');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('posts');
    }
}
