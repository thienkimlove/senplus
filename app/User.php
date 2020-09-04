<?php

namespace App;

use App\Models\Company;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;
    use CrudTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'company_id',
        'filters'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = [
        'display_role'
    ];

    public function getDisplayRoleAttribute()
    {
        if ($this->hasRole('admin')) {
            return 'Admin SenPlus';
        }

        if ($this->hasRole('editor')) {
            return 'Editor SenPlus';
        }

        return  'Người Dùng';
    }


    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
