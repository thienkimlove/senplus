<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTablePosts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->nullable();

            $table->text('desc')->nullable();
            $table->longText('content');
            $table->string('square_image')->nullable();
            $table->string('circle_image')->nullable();

            $table->boolean('status')->default(true);

            $table->timestamps();
        });

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

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');

        Schema::table('main_topic_posts', function (Blueprint $table) {
            $table->dropUnique('main_unique_topic_and_post');
        });

        Schema::table('other_topic_posts', function (Blueprint $table) {
            $table->dropUnique('other_unique_topic_and_post');
        });

        Schema::dropIfExists('main_topic_posts');
        Schema::dropIfExists('other_topic_posts');
    }
}
