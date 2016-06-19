<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tags', function(Blueprint $table) {
            $table->increments('id');
            $table->string('label');

            $table->string('slug');
            $table->unique('slug');

            $table->timestamps();
        });

        Schema::create('resource_tag', function(Blueprint $table) {
            $table->integer('resource_id')->unsigned()->index()->nullable();
            $table->foreign('resource_id')->references('id')->on('resources')->onDelete('cascade');

            $table->integer('tag_id')->unsigned()->index();
            $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');

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
        Schema::table('resource_tag', function(Blueprint $table) {
            $table->dropForeign('resource_tag_resource_id_foreign');
            $table->dropForeign('resource_tag_tag_id_foreign');
        });

        Schema::drop('tags');
        Schema::drop('resource_tag');
    }
}
