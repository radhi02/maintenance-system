<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use Yajra\Auditable\AuditableWithDeletesTrait;
use Spatie\Permission\Traits\HasRoles;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use HasFactory;
    use SoftDeletes;
    use HasRoles;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */


  

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'user_status',
        'Role',
        'Country',
        'State',
        'city',
        'user_status',
        'Image',
        'unit_id',  
        'company_id',  
        'department_id', 
        'emp_code',
        'Phone'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // public function getRoles()
    // {
     
    //     return $this->morphToMany(RoleModel::class,'id','Role');
    // }

    // User::resolveRelationUsing('Roles', function ($roles)
    // {
    //     return $roles->belongsTo(::class, 'Role');
    // });/
}
