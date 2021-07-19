<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname', 'lastname', 'phone', 'email', 'password', 'email_verified_at',
        'address', 'state', 'lga', 'dob', 'photo', 'status', 'activation_token'
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

    public function user_state() {
        return $this->hasOne(State::class,'id', 'state');
    }

    public function user_lga() {
        return $this->hasOne(Lga::class,'id', 'lga');
    }

    public function userRole() {
        return $this->hasOne(UserRole::class,'user_id', 'id');
    }

    public function hasRole($roles)
    {
        // dd();
        if (is_array($roles)) {
            foreach ($roles as $role) {
                if(!Role::where('code',$role)->exists()){
                    return false;
                }
                $mRole = Role::where('code',$role)->first();
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
