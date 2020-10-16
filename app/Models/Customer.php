<?php

namespace App\Models;

use App\Helpers;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Customer extends Authenticatable
{
    use CrudTrait;
    use Notifiable;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'customers';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    protected $fillable = [
        'name',
        'phone',
        'address',
        'email',
        'company_id',
        'password',
        'options',
        'status',
        'level',
        'gender',
        'avatar',
        'token'
    ];
    protected $hidden = ['password'];
    // protected $dates = [];

    public $appends = ['display_level'];

    public $casts = [
        'options' => 'array'
    ];


    public function getDisplayLevelAttribute()
    {
        return Helpers::mapLevel()[$this->level];
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

    public function company()
    {
        return $this->belongsTo(Company::class);
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
