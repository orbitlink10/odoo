<?php

namespace Database\Seeders\Core;

use App\Models\Module;
use App\Models\Role;
use App\Models\Tenant;
use App\Models\User;
use App\Services\BillingService;
use Database\Seeders\Modules\HospitalDemoSeeder;
use Database\Seeders\Modules\PosDemoSeeder;
use Database\Seeders\Modules\PropertyDemoSeeder;
use Database\Seeders\Modules\SchoolDemoSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoTenantSeeder extends Seeder
{
    public function run(): void
    {
        User::query()->where('email', 'superadmin@tiwi.co.ke')->delete();

        $superAdmin = User::query()->updateOrCreate(
            ['email' => 'reisenseo@gmail.com'],
            [
                'name' => 'Tiwi Platform Admin',
                'password' => Hash::make('admin123'),
                'is_super_admin' => true,
                'is_active' => true,
                'tenant_id' => null,
                'email_verified_at' => now(),
            ]
        );

        $superRole = Role::query()->where('slug', 'super-admin')->first();
        if ($superRole) {
            $superAdmin->roles()->syncWithoutDetaching([$superRole->id]);
        }

        $tenant = Tenant::query()->updateOrCreate(
            ['slug' => 'demo-campus'],
            [
                'name' => 'Demo Campus Ltd',
                'country' => 'KE',
                'timezone' => 'Africa/Nairobi',
                'currency' => 'KES',
                'is_active' => true,
                'settings' => [
                    'vat_rate' => 16,
                    'sms_provider' => null,
                    'email_provider' => null,
                ],
            ]
        );

        $tenantAdmin = User::query()->updateOrCreate(
            ['email' => 'admin@demo.tiwi.co.ke'],
            [
                'tenant_id' => $tenant->id,
                'name' => 'Demo Tenant Admin',
                'phone' => '+254700000001',
                'password' => Hash::make('password'),
                'is_super_admin' => false,
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        $tenantAdminRole = Role::query()->where('slug', 'tenant-admin')->first();
        if ($tenantAdminRole) {
            $tenantAdmin->roles()->syncWithoutDetaching([$tenantAdminRole->id]);
        }

        $moduleSlugs = Module::query()->pluck('slug')->all();
        $subscription = app(BillingService::class)->createOrUpdateSubscription(
            tenant: $tenant,
            moduleSlugs: $moduleSlugs,
            planId: null,
            startTrial: true,
            trialDays: 14,
        );
        app(BillingService::class)->generateInvoiceForSubscription($subscription);

        $this->call([
            SchoolDemoSeeder::class,
            HospitalDemoSeeder::class,
            PropertyDemoSeeder::class,
            PosDemoSeeder::class,
        ]);
    }
}
