<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Database\Events\MigrationsEnded;
use Illuminate\Support\Facades\Artisan;

class GeneratePermissionsAfterMigration
{
    /**
     * Handle the event.
     */
    public function handle(MigrationsEnded $event): void
    {
        // Run your artisan command automatically
        Artisan::call('generate:permissions');
        echo "🔄 Permissions regenerated after migration.\n";
    }
}
