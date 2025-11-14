<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

class MakeModelWithPermissions extends Command
{
    protected $signature = 'make:model-perm {name : The name of the model} {--m|migration : Create a new migration file for the model} {--c|controller : Create a new controller for the model} {--r|resource : Generate a resource controller for the model}';

    protected $description = 'Create a model and automatically generate permissions for it';

    public function handle()
    {
        $name = $this->argument('name');

        // Step 1: Run the normal make:model command with options
        $this->info("⚙️ Creating model {$name}...");
        Artisan::call('make:model', [
            'name' => $name,
            '--migration' => $this->option('migration'),
            '--controller' => $this->option('controller'),
            '--resource' => $this->option('resource'),
        ]);

        // Step 2: Generate permissions automatically
        $modelName = Str::snake(Str::pluralStudly($name));
        $permissions = [
            "view {$modelName}",
            "create {$modelName}",
            "edit {$modelName}",
            "delete {$modelName}",
        ];

        $this->info("🔐 Generating permissions for {$modelName}...");

        foreach ($permissions as $permission) {
            Artisan::call('permission:create-permission', ['name' => $permission]);
            $this->line("✅ Created: {$permission}");
        }

        $this->info("✅ Model {$name} and permissions created successfully.");
    }
}
