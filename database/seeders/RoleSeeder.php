<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $admin = [
            'id'=>1,
            'title'=>'Admin',
        ];

        $user = [
            'id'=>2,
            'title'=>'User',
        ];

        $roles = [$admin,$user];

        $list_permissions = [
            ['title'=>'user_list_view'],
            ['title'=>'user_list_update',],
            ['title'=>'user_list_create',],
            ['title'=>'user_list_delete',],
        ];

        Permission::insert($list_permissions);

        Role::insert($roles);

        $adminRole = Role::find($admin['id']);
        $adminRole->permissions()->attach(Permission::all()->pluck('id')->toArray());

        $userRole = Role::find($user['id']);
        $userPermissions = Permission::orWhere('title','user_list_view')
            ->orWhere('title','user_list_update')
            ->orWhere('title','user_list_create')
            ->orWhere('title','user_list_delete')
            ->get();

        $userRole->permissions()->attach($userPermissions->pluck('id')->toArray());
    }
}
