<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'companies';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    protected $fillable = [
        'name',
        'brand_name',
        'main_address',
        'contact_phone',
        'logo',
        'business_field_id',
        'employee_number_id',
        'average_income_id',
        'total_fund_id',
    ];
    // protected $hidden = [];
    // protected $dates = [];

    public $appends = [
        'is_default'
    ];

    public function getIsDefaultAttribute()
    {
        return ($this->name == 'Default');
    }

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

    public function filters()
    {
        return $this->belongsToMany(Filter::class);
    }

    public function income()
    {
        return $this->belongsTo(Income::class, 'average_income_id');
    }

    public function business()
    {
        return $this->belongsTo(Business::class, 'business_field_id');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_number_id');
    }

    public function fund()
    {
        return $this->belongsTo(Fund::class, 'total_fund_id');
    }

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
