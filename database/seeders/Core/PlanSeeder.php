<?php

namespace Database\Seeders\Core;

use App\Models\Module;
use App\Models\Plan;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    public function run(): void
    {
        $plans = [
            ['name' => 'Starter', 'slug' => 'starter', 'description' => 'Any one app', 'monthly_price' => 2500, 'trial_days' => 14],
            ['name' => 'Growth', 'slug' => 'growth', 'description' => 'Any two apps', 'monthly_price' => 5200, 'trial_days' => 14],
            ['name' => 'Scale', 'slug' => 'scale', 'description' => 'All apps', 'monthly_price' => 9500, 'trial_days' => 14],
        ];

        foreach ($plans as $planData) {
            $plan = Plan::query()->updateOrCreate(['slug' => $planData['slug']], $planData);

            $modules = Module::query()->get();
            $sync = [];

            foreach ($modules as $module) {
                $sync[$module->id] = ['price_override' => $module->base_price];
            }

            $plan->modules()->sync($sync);
        }
    }
}
