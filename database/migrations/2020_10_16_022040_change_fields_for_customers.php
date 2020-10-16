<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeFieldsForCustomers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customers', function (Blueprint $table) {

            $table->dropUnique('login_company_id_field_unique');

            $table->dropColumn([
                'login',
                'username',
                'first_name',
                'last_name'
            ]);

            $table->unique(['email', 'company_id'], 'email_company_id_field_unique');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropUnique('email_company_id_field_unique');

            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('login');

            $table->unique(['login', 'company_id'], 'login_company_id_field_unique');
        });
    }
}
