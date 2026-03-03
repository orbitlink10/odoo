<?php

namespace Database\Seeders;

use Database\Seeders\Core\DemoTenantSeeder;
use Database\Seeders\Core\ModuleSeeder;
use Database\Seeders\Core\PermissionSeeder;
use Database\Seeders\Core\PlanSeeder;
use Database\Seeders\Core\RoleSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            ModuleSeeder::class,
            PlanSeeder::class,
            PermissionSeeder::class,
            RoleSeeder::class,
            DemoTenantSeeder::class,
        ]);
    }
}
