<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Define permissions
        $permissions = [
            'view dashboard',
            'edit profile',
            'view members',
            'create members',
            'edit members',
            'delete members',
            'view departments',
            'create departments',
            'edit departments',
            'delete departments',
            'view pastors',
            'create pastors',
            'edit pastors',
            'delete pastors',
            'view events',
            'create events',
            'edit events',
            'delete events',
            'add event photos',
            'delete event photos',
            'view attendance',
            'create attendance',
            'edit attendance',
            'delete attendance',
            'view expenses',
            'create expenses',
            'edit expenses',
            'delete expenses',
            'view financial records',
            'create financial records',
            'edit financial records',
            'delete financial records',
            'view pledges',
            'create pledges',
            'edit pledges',
            'delete pledges',
            'view equipments',
            'create equipments',
            'edit equipments',
            'delete equipments',
            'view sermons',
            'create sermons',
            'edit sermons',
            'delete sermons',
            'search',
            'logout',
            'manage roles and permissions',
            'assign roles',
            'assign permissions',
            'view user roles',
            'edit user roles'
        ];

        // Create permissions
        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm]);
        }

        // Create roles
        $admin = Role::firstOrCreate(['name' => 'Admin']);
        $guest = Role::firstOrCreate(['name' => 'Guest']);

        // Assign all permissions to Admin
        $admin->syncPermissions(Permission::all());

        // Assign minimal permissions to Guest (example)
        $guest->syncPermissions(['view dashboard', 'edit profile', 'search', 'logout']);

        $this->command->info('✅ Roles and permissions seeded successfully!');
    }
}
