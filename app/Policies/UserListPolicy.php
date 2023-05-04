<?php

namespace App\Policies;

use App\Models\User;
use App\Models\UserList;
use App\Models\UserUserPermission;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserListPolicy extends CheckAccess
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\UserList  $userList
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, UserList $userList)
    {
        return ($user->id === $userList->user_id && $this->checkAccess($user,'user_list_view')) || $this->isAdmin($user);
    }

    public function viewAll(User $user, User $otherUser)
    {
        return $this->checkAccessBetweenUsers($user,$otherUser,'user_list_view') || $this->isAdmin($user) || ($otherUser->id == $user->id);
    }


    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user, User $otherUser)
    {

        return  $this->checkAccessBetweenUsers($user,$otherUser,'user_list_create') || $this->isAdmin($user) || ($otherUser->id == $user->id);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\UserList  $userList
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, UserList $userList, User $otherUser)
    {

        return  $this->checkAccessBetweenUsers($user,$otherUser,'user_list_update') || $this->isAdmin($user) || ($otherUser->id == $user->id) || $userList->user_id == $user->id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\UserList  $userList
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, UserList $userList, User $otherUser)
    {
        return  $this->checkAccessBetweenUsers($user,$otherUser,'user_list_delete') || $this->isAdmin($user) || ($otherUser->id == $user->id) || $userList->user_id == $user->id;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\UserList  $userList
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, UserList $userList)
    {

    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\UserList  $userList
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, UserList $userList)
    {

    }
}
