<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeOnPosts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('main_topic_posts', function (Blueprint $table) {
            $table->dropUnique('main_unique_topic_and_post');
        });

        Schema::table('other_topic_posts', function (Blueprint $table) {
            $table->dropUnique('other_unique_topic_and_post');
        });

        Schema::dropIfExists('main_topic_posts');
        Schema::dropIfExists('other_topic_posts');

        Schema::create('post_topic', function (Blueprint $table) {
            $table->unsignedBigInteger('post_id');
            $table->unsignedBigInteger('topic_id');
            $table->unique(['topic_id', 'post_id'], 'unique_topic_and_post');
        });

        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn(['square_image', 'circle_image']);
            $table->string('image')->nullable();
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('main_topic_posts', function (Blueprint $table) {
            $table->unsignedBigInteger('post_id');
            $table->unsignedBigInteger('topic_id');
            $table->unique(['topic_id', 'post_id'], 'main_unique_topic_and_post');
        });

        Schema::create('other_topic_posts', function (Blueprint $table) {
            $table->unsignedBigInteger('post_id');
            $table->unsignedBigInteger('topic_id');
            $table->unique(['topic_id', 'post_id'], 'other_unique_topic_and_post');
        });


        Schema::table('post_topic', function (Blueprint $table) {
            $table->dropUnique('unique_topic_and_post');
        });

        Schema::dropIfExists('post_topic');

        Schema::table('posts', function (Blueprint $table) {
            $table->string('square_image')->nullable();
            $table->string('circle_image')->nullable();
        });


    }
}
