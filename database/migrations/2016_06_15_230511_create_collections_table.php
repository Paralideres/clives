<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCollectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('collections', function (Blueprint $table) {
            $table->increments('id');
            $table->string('label');

            $table->string('slug');

            $table->text('description')->nullable();

            $table->integer('former_id')->unsigned()->nullable();
            $table->integer('former_parent_id')->unsigned()->nullable();

            $table->integer('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->integer('category_id')->unsigned()->index();
            $table->foreign('category_id')->references('id')->on('categories');

            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('collection_resource', function(Blueprint $table) {
            $table->integer('collection_id')->unsigned()->index();
            $table->foreign('collection_id')->references('id')->on('collections')->onDelete('cascade');

            $table->integer('resource_id')->unsigned()->index();
            $table->foreign('resource_id')->references('id')->on('resources')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::table('resources', function (Blueprint $table) {
            $table->integer('category_id')->unsigned()->nullable();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('resources', function (Blueprint $table) {
            $table->dropForeign('resources_category_id_foreign');
            $table->dropColumn('category_id');
        });

        Schema::table('collections', function(Blueprint $table) {
            $table->dropForeign('collections_user_id_foreign');
            $table->dropForeign('collections_category_id_foreign');
        });

        Schema::table('collection_resource', function(Blueprint $table) {
            $table->dropForeign('collection_resource_collection_id_foreign');
            $table->dropForeign('collection_resource_resource_id_foreign');
        });

        Schema::drop('collections');
        Schema::drop('collection_resource');
    }
}
