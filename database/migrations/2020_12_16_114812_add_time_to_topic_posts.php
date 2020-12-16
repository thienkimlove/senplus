<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTimeToTopicPosts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post_topic_extends', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('post_id');
            $table->unsignedBigInteger('topic_id');
            $table->unique(['topic_id', 'post_id'], 'unique_topic_and_post_extend');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('post_topic_extends', function (Blueprint $table) {
            $table->dropUnique('unique_topic_and_post_extend');
        });

        Schema::dropIfExists('post_topic_extends');
    }
}
