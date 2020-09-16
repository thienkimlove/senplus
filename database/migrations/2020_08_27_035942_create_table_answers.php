<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableAnswers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('answers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('question_id');
            $table->unsignedSmallInteger('option1')->default(0);
            $table->unsignedSmallInteger('option2')->default(0);
            $table->unsignedSmallInteger('option3')->default(0);
            $table->unsignedSmallInteger('option4')->default(0);

            $table->unique(['customer_id', 'question_id'],'unique_user_question');

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
        Schema::dropIfExists('answers');
    }
}
