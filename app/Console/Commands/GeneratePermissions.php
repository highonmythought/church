<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class GeneratePermissions extends Command
{
    protected $signature = 'generate:permissions';
    protected $description = 'Automatically create CRUD permissions for all models in the app/Models directory';

    public function handle()
    {
        $modelPath = app_path('Models');
        $files = File::files($modelPath);

        $actions = ['view', 'add', 'edit', 'delete'];
        $createdCount = 0;

        foreach ($files as $file) {
            $model = pathinfo($file->getFilename(), PATHINFO_FILENAME);
            $table = strtolower(str_replace('_', ' ', $model));

            foreach ($actions as $action) {
                $permissionName = "{$action} {$table}";

                // ✅ Create the permission if it doesn't exist
                if (!Permission::where('name', $permissionName)->exists()) {
                    Permission::create(['name' => $permissionName, 'guard_name' => 'web']);
                    $this->info("Created permission: {$permissionName}");
                    $createdCount++;

                    // ✅ Assign it to Admin automatically
                    $adminRole = Role::where('name', 'Admin')->first();
                    if ($adminRole) {
                        $adminRole->givePermissionTo($permissionName);
                        $this->info("→ Assigned to Admin role");
                    }
                }
            }
        }

        if ($createdCount === 0) {
            $this->info('✅ All permissions already exist.');
        } else {
            $this->info("✅ Done! {$createdCount} new permissions added and assigned to Admin.");
        }
    }
}
