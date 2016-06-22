<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePollsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('polls', function(Blueprint $table) {
            $table->increments('id');

            $table->string('question');
            $table->date('date_from');
            $table->date('date_to');
            $table->boolean('active');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('poll_options', function(Blueprint $table) {
            $table->increments('id');
            $table->string('option');
            $table->integer('index')->unsigned();
            $table->integer('poll_id')->unsigned();

            $table->foreign('poll_id')->references('id')->on('polls')->onDelete('cascade');
        });

        Schema::create('poll_user', function(Blueprint $table) {
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->integer('poll_id')->unsigned()->index();
            $table->foreign('poll_id')->references('id')->on('polls')->onDelete('cascade');

            $table->integer('poll_options_id')->unsigned()->index();
            $table->foreign('poll_options_id')->references('id')->on('poll_options')->onDelete('cascade');

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
        Schema::table('poll_user', function(Blueprint $table) {
            $table->dropForeign('poll_user_user_id_foreign');
            $table->dropForeign('poll_user_poll_id_foreign');
            $table->dropForeign('poll_user_poll_options_id_foreign');
        });

        Schema::drop('poll_user');
        Schema::drop('poll_options');
        Schema::drop('polls');
    }
}
