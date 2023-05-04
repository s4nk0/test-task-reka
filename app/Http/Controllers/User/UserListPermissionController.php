<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\ListPermission\StoreUserUserPermissionRequest;
use App\Http\Requests\User\ListPermission\UpdateUserUserPermissionRequest;
use App\Models\Permission;
use App\Models\User;
use App\Models\UserUserPermission;
use Illuminate\Support\Facades\Auth;

class UserListPermissionController extends Controller
{

    public function index()
    {
        $user =  Auth::user();
        $givenMePermissions = $user->givenMePermissions;
        $givenPermissions = $user->givenPermissions;
        return view('user.list-permission.index', compact('givenMePermissions','givenPermissions'));
    }

    public function create()
    {
        $users = User::all()->except(Auth::id());
        $permissions = Permission::all();
        return view('user.list-permission.create', compact('permissions','users'));
    }

    public function store(StoreUserUserPermissionRequest $request)
    {
        $user = Auth::user();

        $user->givenPermissions()->create($request->validated());
        return redirect()->route('user.listPermission.index');
    }

    public function show(UserUserPermission $userUserPermission)
    {
        //
    }

    public function edit(UserUserPermission $userUserPermission)
    {
        //
    }

    public function update(UpdateUserUserPermissionRequest $request, UserUserPermission $userUserPermission)
    {
        //
    }

    public function destroy(UserUserPermission $listPermission)
    {
        $user = Auth::user();

        $user->givenPermissions()->find($listPermission)->first()->delete();
        return redirect()->route('user.listPermission.index');
    }
}
