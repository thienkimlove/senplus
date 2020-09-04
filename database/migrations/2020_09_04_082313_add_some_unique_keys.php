<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSomeUniqueKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('answers', function (Blueprint $table) {
            $table->unique(['user_id', 'question_id'], 'unique_user_question');
        });

        Schema::table('questions', function (Blueprint $table) {
            $table->unique(['round', 'order', 'company_id'], 'unique_round_order_company');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('answers', function (Blueprint $table) {
            $table->dropUnique('unique_user_question');
        });

        Schema::table('questions', function (Blueprint $table) {
            $table->dropUnique('unique_round_order_company');
        });
    }
}
