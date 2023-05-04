<?php

namespace App\Policies;

use App\Enums\RolesEnum;
use App\Models\User;
use App\Models\UserUserPermission;

class CheckAccess
{
    public function checkAccess(User $user,$permission){
        $roles = $user->roles()->get()->first();

        if ($roles){
            return $roles->permissions()->where('title',$permission)->get()->count();
        }else{
            return false;
        }
    }

    public function checkAccessBetweenUsers(User $user, User $otherUser,$permission){
        $givenPermissions = UserUserPermission::where('other_user_id',$user->id)->where('user_id',$otherUser->id)->with('permission')->get();
        if (!$givenPermissions->count()){
            return false ;
        }

        $getNeededPermission = $givenPermissions->where('permission.title',$permission)->first();

        return ($getNeededPermission) ? true : false;
    }

    public function isAdmin(User $user){
        if ($user->hasRoles(['Admin'])){
            return true;
        } else{
            return false;
        }
    }
}
