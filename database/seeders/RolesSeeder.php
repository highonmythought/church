<?php


namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    public function run()
    {
        // Create Admin role if it doesn't exist
        if (!Role::where('name', 'Admin')->exists()) {
            Role::create(['name' => 'Admin']);
        }

        // Create Guest role if it doesn't exist
        if (!Role::where('name', 'Guest')->exists()) {
            Role::create(['name' => 'Guest']);
        }
    }
}
