<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname', 'lastname', 'phone', 'type', 'email', 'password', 'email_verified_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function userRole() {
        return $this->hasOne(UserRole::class,'user_id', 'id');
    }

    public function hasRole($roles)
    {
        if (is_array($roles)) {
            foreach ($roles as $role) {
                if(!Role::where('role',$role)->exists()){
                    return false;
                }
                $mRole = Role::where('role',$role)->first();
                if (UserRole::where(['role_id'=>$mRole->id,'user_id'=>Auth::user()->id])->exists()) {
                    return true;
                }
            }
            return false;
        }
    }
    public function role() {
        return $this->hasOne(UserRole::class,'user_id', 'id')
        ->join('roles', 'roles.id', 'user_roles.role_id')
        ->select('roles.code', 'roles.role', 'roles.id as role_id', 'user_roles.role_id', 'user_roles.user_id');
    }
}
