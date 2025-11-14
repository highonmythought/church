<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Clear cache
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            'manage members',
            'manage departments',
            'manage pastors',
            'manage events',
            'manage attendances',
            'manage expenses',
            'manage financial records',
            'manage pledges',
            'manage equipments',
            'manage sermons',
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm]);
        }

        // Create roles
        $admin = Role::firstOrCreate(['name' => 'Admin']);
        $pastor = Role::firstOrCreate(['name' => 'Pastor']);
        $accountant = Role::firstOrCreate(['name' => 'Accountant']);
        $guest = Role::firstOrCreate(['name' => 'Guest']);

        // Assign all permissions to Admin
        $admin->syncPermissions($permissions);

        // Assign limited permissions to Pastor
        $pastor->syncPermissions(['manage sermons']);

        // Assign limited permissions to Accountant
        $accountant->syncPermissions(['manage financial records', 'manage pledges']);
    }
}
