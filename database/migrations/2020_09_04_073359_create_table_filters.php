<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableFilters extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('filters', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->longText('options')->nullable();
            $table->boolean('is_level')->default(false);
            $table->timestamps();
        });


        Schema::create('company_filter', function (Blueprint $table) {
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('filter_id');
            $table->unique(['company_id', 'filter_id'], 'unique_company_filter');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('filters', function (Blueprint $table) {
            $table->dropUnique('unique_company_filter');
        });
        Schema::dropIfExists('company_filter');
        Schema::dropIfExists('filters');
    }
}
