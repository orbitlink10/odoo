<?php

namespace Database\Seeders\Core;

use App\Models\Module;
use Illuminate\Database\Seeder;

class ModuleSeeder extends Seeder
{
    public function run(): void
    {
        $modules = [
            ['name' => 'School', 'slug' => 'school', 'description' => 'School management', 'base_price' => 2500],
            ['name' => 'Hospital', 'slug' => 'hospital', 'description' => 'Hospital management', 'base_price' => 3500],
            ['name' => 'Property', 'slug' => 'property', 'description' => 'Property management', 'base_price' => 2800],
            ['name' => 'POS', 'slug' => 'pos', 'description' => 'Point of Sale', 'base_price' => 2200],
        ];

        // Enforce exactly the 4 supported Tiwi modules.
        Module::query()->whereNotIn('slug', array_column($modules, 'slug'))->delete();

        foreach ($modules as $module) {
            Module::query()->updateOrCreate(['slug' => $module['slug']], $module);
        }
    }
}
