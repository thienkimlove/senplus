<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class Explain extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'explains';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    protected $fillable = [
        'option',
        'ten_van_hoa',
        'nang_luc_canh_tranh',
        'gia_tri_dem_lai',
        'xu_huong',
        'uu_diem',
        'nhuoc_diem',
        'dac_diem_noi_troi',
        'phong_cach_lanh_dao',
        'quan_ly_nhan_vien',
        'su_gan_ket',
        'chien_luoc',
        'tieu_chi_thanh_cong'
    ];
    // protected $hidden = [];
    // protected $dates = [];

    protected $casts = [
        'xu_huong' => 'array',
        'uu_diem' => 'array',
        'nhuoc_diem' => 'array',
    ];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
