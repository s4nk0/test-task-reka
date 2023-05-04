<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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

    public function roles(){
        return $this->belongsToMany(Role::class);
    }

    public function hasRoles($roles){
        return count(array_intersect($roles,$this->roles->pluck('title')->toArray()));
    }

    public function lists(){
        return $this->hasMany(UserList::class,'user_id','id');
    }

    public function givenMePermissions(){
        return $this->hasMany(UserUserPermission::class,'other_user_id', 'id');
    }

    public function givenPermissions(){
        return $this->hasMany(UserUserPermission::class,'user_id', 'id');
    }
}
