<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableSurveys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('surveys', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('company_id')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
        });

        Schema::table('questions', function (Blueprint $table) {
            $table->dropUnique('unique_round_order_company');
            $table->dropColumn('company_id');
            $table->unsignedBigInteger('survey_id');
            $table->unique(['round', 'order', 'survey_id'], 'unique_round_order_survey');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('surveys');

        Schema::table('questions', function (Blueprint $table) {
            $table->dropUnique('unique_round_order_survey');
            $table->dropColumn('survey_id');
            $table->unsignedBigInteger('company_id')->nullable();
            $table->unique(['round', 'order', 'company_id'], 'unique_round_order_company');


        });
    }
}
