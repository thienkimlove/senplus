<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMoreFieldToCompanies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('business_fields', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('employee_numbers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('average_incomes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('total_funds', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::table('companies', function (Blueprint $table) {
            $table->string('brand_name')->nullable();
            $table->text('main_address')->nullable();
            $table->string('contact_phone')->nullable();
            $table->string('logo')->nullable();
            $table->unsignedBigInteger('business_field_id')->nullable();
            $table->unsignedBigInteger('employee_number_id')->nullable();
            $table->unsignedBigInteger('average_income_id')->nullable();
            $table->unsignedBigInteger('total_fund_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::dropIfExists('business_fields');
        Schema::dropIfExists('employee_numbers');
        Schema::dropIfExists('average_incomes');
        Schema::dropIfExists('total_funds');

        Schema::table('companies', function (Blueprint $table) {



            $table->dropColumn([
                'brand_name',
                'main_address',
                'contact_phone',
                'logo',
                'business_field_id',
                'employee_number_id',
                'average_income_id',
                'total_fund_id',
            ]);
        });
    }
}
