<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToExplains extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('explains', function (Blueprint $table) {
            $table->text('dac_diem_noi_troi')->nullable();
            $table->text('phong_cach_lanh_dao')->nullable();
            $table->text('quan_ly_nhan_vien')->nullable();
            $table->text('su_gan_ket')->nullable();
            $table->text('chien_luoc')->nullable();
            $table->text('tieu_chi_thanh_cong')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('explains', function (Blueprint $table) {
            $table->dropColumn([
                'dac_diem_noi_troi',
                'phong_cach_lanh_dao',
                'quan_ly_nhan_vien',
                'su_gan_ket',
                'chien_luoc',
                'tieu_chi_thanh_cong'
            ]);
        });
    }
}
