<?php

namespace App\Http\Controllers;

use App\Permission;
use App\Role;
use App\User;
use App\Http\Requests;
use Illuminate\Http\Request;

class RolesController extends Controller
{
    public function createRole(Request $request)
    {
        $role = new Role();
        $role->name = $request->input('name');
        $role->save();
        return response()->json($role);
    }

    public function createPermission(Request $request)
    {
        $permission = new Permission();
        $permission->name = $request->input('name');
        $permission->save();
        return response()->json($permission);
    }

    public function assignRole(Request $request)
    {
        $user = User::where('email', '=', $request->input('email'))->first();
        $role = Role::where('name', '=', $request->input('role'))->first();

        $user->roles()->attach($role->id);

        return response()->json('Success', 200);
    }

    public function attachPermission(Request $request)
    {
        $role = Role::where('name', '=', $request->input('role'))->first();
        $permission = Permission::where('name', '=', $request->input('name'))->first();

        $role->attachPermission($permission);

        return response()->json('Success', 200);
    }

}
