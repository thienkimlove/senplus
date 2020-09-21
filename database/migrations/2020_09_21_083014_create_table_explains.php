<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableExplains extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('explains', function (Blueprint $table) {
            $table->id();
            $table->string('option')->unique();
            $table->string('ten_van_hoa');
            $table->string('nang_luc_canh_tranh');
            $table->string('gia_tri_dem_lai');
            $table->text('xu_huong');
            $table->text('uu_diem');
            $table->text('nhuoc_diem');
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
        Schema::dropIfExists('explains');
    }
}
