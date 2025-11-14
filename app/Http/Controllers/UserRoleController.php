<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserRoleController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->get();
        return view('users.roles.index', compact('users'));
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        return view('users.roles.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $user->syncRoles($request->roles);
        return redirect()->route('users.roles.index')->with('success', 'User roles updated successfully!');
    }
}
