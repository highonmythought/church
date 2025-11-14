<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Validate input
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Ensure roles and permissions exist
        $this->ensureRolesAndPermissions();

        // Create the user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Assign role: first user -> Admin, others -> Guest
        if (User::count() === 1) {
            $user->assignRole('Admin');
        } else {
            $user->assignRole('Guest');
        }

        // Fire registered event
        event(new Registered($user));

        // Log in the user
        Auth::login($user);

        return redirect(route('dashboard'));
    }

    /**
     * Ensure default roles and permissions exist.
     */
    private function ensureRolesAndPermissions()
    {
        if (Role::count() === 0 || Permission::count() === 0) {
            // Reset cached roles and permissions
            app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

            // Define permissions
            $permissions = [
                'view dashboard', 'edit profile',
                'view members', 'create members', 'edit members', 'delete members',
                'view departments', 'create departments', 'edit departments', 'delete departments',
                'view pastors', 'create pastors', 'edit pastors', 'delete pastors',
                'view events', 'create events', 'edit events', 'delete events',
                'add event photos', 'delete event photos',
                'view attendance', 'create attendance', 'edit attendance', 'delete attendance',
                'view expenses', 'create expenses', 'edit expenses', 'delete expenses',
                'view financial records', 'create financial records', 'edit financial records', 'delete financial records',
                'view pledges', 'create pledges', 'edit pledges', 'delete pledges',
                'view equipments', 'create equipments', 'edit equipments', 'delete equipments',
                'view sermons', 'create sermons', 'edit sermons', 'delete sermons',
                'search', 'logout',
                'manage roles and permissions', 'assign roles', 'assign permissions',
                'view user roles', 'edit user roles'
            ];

            // Create permissions
            foreach ($permissions as $perm) {
                Permission::firstOrCreate(['name' => $perm]);
            }

            // Create roles
            $admin = Role::firstOrCreate(['name' => 'Admin']);
            $guest = Role::firstOrCreate(['name' => 'Guest']);

            // Assign permissions
            $admin->syncPermissions(Permission::all());
            $guest->syncPermissions(['view dashboard', 'edit profile', 'search', 'logout']);
        }
    }
}
