<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserUserPermission extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'other_user_id',
        'permission_id',
    ];

    public function permission(){
        return $this->hasOne(Permission::class,'id','permission_id');
    }

    public function otherUser(){
        return $this->hasOne(User::class, 'id','other_user_id');
    }

    public function user(){
        return $this->hasOne(User::class, 'id','user_id');
    }
}
