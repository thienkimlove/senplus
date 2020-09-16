<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableQuestions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->unsignedBigInteger('survey_id')->nullable();
            $table->unsignedSmallInteger('round');
            $table->unsignedSmallInteger('order');
            $table->string('option1');
            $table->string('option2');
            $table->string('option3');
            $table->string('option4');

            $table->unique(['round', 'order', 'survey_id'], 'unique_round_order_survey');

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
        Schema::dropIfExists('questions');
    }
}
