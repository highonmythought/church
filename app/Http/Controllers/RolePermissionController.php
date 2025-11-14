<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolePermissionController extends Controller
{
    // Show roles, permissions, and users
    public function index()
    {
        $roles = Role::all();
        $permissions = Permission::all();
        $users = User::with('roles', 'permissions')->get();

        return view('roles_permissions.index', compact('roles', 'permissions', 'users'));
    }

    // Store a new role
    public function storeRole(Request $request)
    {
        $request->validate(['name' => 'required|unique:roles,name']);
        Role::create(['name' => $request->name]);
        return back()->with('success', 'Role created successfully.');
    }

    // Store a new permission
    public function storePermission(Request $request)
    {
        $request->validate(['name' => 'required|unique:permissions,name']);
        Permission::create(['name' => $request->name]);
        return back()->with('success', 'Permission created successfully.');
    }

    // Assign a role to a user
    public function assignRole(Request $request)
    {
        $request->validate(['user_id' => 'required', 'role' => 'required']);
        $user = User::find($request->user_id);
        $user->assignRole($request->role);
        return back()->with('success', 'Role assigned successfully.');
    }

    // Assign a permission to a user
    public function assignPermission(Request $request)
    {
        $request->validate(['user_id' => 'required', 'permission' => 'required']);
        $user = User::find($request->user_id);
        $user->givePermissionTo($request->permission);
        return back()->with('success', 'Permission assigned successfully.');
    }


    public function removeRole(User $user, Role $role)
{
    $user->removeRole($role->name);
    return back()->with('success', 'Role removed successfully.');
}

public function removePermission(Role $role, Permission $permission)
{
    $role->revokePermissionTo($permission->name);
    return back()->with('success', 'Permission removed successfully.');
}

public function deleteUser(User $user)
{
    $user->delete();
    return back()->with('success', 'User deleted successfully.');
}

}



