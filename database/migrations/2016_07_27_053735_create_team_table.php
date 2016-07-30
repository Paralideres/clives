<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeamTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teams', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('team_log', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->index();
            $table->string('action');
            $table->boolean('sys_action')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('team_users', function(Blueprint $table) {
            $table->integer('team_id')->unsigned()->index();
            $table->foreign('team_id')->references('id')->on('teams')->onDelete('cascade');

            $table->integer('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->boolean('is_admin')->nullable();
            $table->timestamps();
        });

        Schema::create('resources_team', function(Blueprint $table) {
            $table->increments('id');

            $table->integer('team_id')->unsigned()->index();
            $table->foreign('team_id')->references('id')->on('teams')->onDelete('cascade');

            $table->integer('resource_id')->unsigned()->index();
            $table->foreign('resource_id')->references('id')->on('resources')->onDelete('cascade');

            $table->integer('shared_by')->unsigned();
            $table->integer('archived_by')->nullable();
            $table->date('archived_at')->nullable();
            $table->timestamps();
        });

        Schema::create('team_comments', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('resource_team_id')->unsigned()->index();
            $table->foreign('resource_team_id')->references('id')->on('resources_team')->onDelete('cascade');

            $table->integer('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->string('content');
            $table->integer('reply_to')->nullable()->unsigned();
            $table->boolean('root_comment')->nullable();
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
        Schema::table('team_comments', function(Blueprint $table) {
            $table->dropForeign('team_comments_resource_team_id_foreign');
            $table->dropForeign('team_comments_user_id_foreign');
        });

        Schema::table('resources_team', function(Blueprint $table) {
            $table->dropForeign('resources_team_team_id_foreign');
            $table->dropForeign('resources_team_resource_id_foreign');
        });

        Schema::table('team_users', function(Blueprint $table) {
            $table->dropForeign('team_users_team_id_foreign');
            $table->dropForeign('team_users_user_id_foreign');
        });

        Schema::drop('team_comments');
        Schema::drop('resources_team');
        Schema::drop('team_users');
        Schema::drop('team_log');
        Schema::drop('teams');
    }
}
