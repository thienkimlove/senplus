<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableCustomers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('company')->nullable();
            
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('username')->nullable();
            $table->string('email')->nullable();
            
            $table->string('phone')->nullable();
            $table->text('address')->nullable();

            $table->string('login');
            $table->string('password');
            $table->longText('options')->nullable();             
            $table->boolean('status')->default(true);

            $table->unsignedTinyInteger('level')->default(0);

            $table->unsignedBigInteger('company_id')->nullable();
            $table->unique(['login', 'company_id'], 'login_company_id_field_unique');
            
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
        Schema::dropIfExists('customers');
    }
}
