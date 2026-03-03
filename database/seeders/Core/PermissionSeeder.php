<?php

namespace Database\Seeders\Core;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            ['name' => 'Super Admin Access', 'slug' => 'platform.super_admin.access', 'module' => 'platform'],
            ['name' => 'Tenant Admin Access', 'slug' => 'platform.tenant_admin.access', 'module' => 'platform'],
            ['name' => 'Billing Manage', 'slug' => 'platform.billing.manage', 'module' => 'platform'],

            ['name' => 'School Students Read', 'slug' => 'school.students.read', 'module' => 'school'],
            ['name' => 'School Students Create', 'slug' => 'school.students.create', 'module' => 'school'],
            ['name' => 'School Classes Read', 'slug' => 'school.classes.read', 'module' => 'school'],
            ['name' => 'School Fees Read', 'slug' => 'school.fees.read', 'module' => 'school'],
            ['name' => 'School Fees Pay', 'slug' => 'school.fees.pay', 'module' => 'school'],
            ['name' => 'School Reports', 'slug' => 'school.reports.read', 'module' => 'school'],

            ['name' => 'Hospital Patients Read', 'slug' => 'hospital.patients.read', 'module' => 'hospital'],
            ['name' => 'Hospital Patients Create', 'slug' => 'hospital.patients.create', 'module' => 'hospital'],
            ['name' => 'Hospital Appointments Read', 'slug' => 'hospital.appointments.read', 'module' => 'hospital'],
            ['name' => 'Hospital Visits Read', 'slug' => 'hospital.visits.read', 'module' => 'hospital'],
            ['name' => 'Hospital Bills Read', 'slug' => 'hospital.bills.read', 'module' => 'hospital'],
            ['name' => 'Hospital Bills Pay', 'slug' => 'hospital.bills.pay', 'module' => 'hospital'],
            ['name' => 'Hospital Reports', 'slug' => 'hospital.reports.read', 'module' => 'hospital'],

            ['name' => 'Property Read', 'slug' => 'property.properties.read', 'module' => 'property'],
            ['name' => 'Property Units Read', 'slug' => 'property.units.read', 'module' => 'property'],
            ['name' => 'Property Leases Read', 'slug' => 'property.leases.read', 'module' => 'property'],
            ['name' => 'Property Rent Read', 'slug' => 'property.rent.read', 'module' => 'property'],
            ['name' => 'Property Rent Collect', 'slug' => 'property.rent.collect', 'module' => 'property'],
            ['name' => 'Property Maintenance Read', 'slug' => 'property.maintenance.read', 'module' => 'property'],
            ['name' => 'Property Reports', 'slug' => 'property.reports.read', 'module' => 'property'],

            ['name' => 'POS Products Read', 'slug' => 'pos.products.read', 'module' => 'pos'],
            ['name' => 'POS Sale Create', 'slug' => 'pos.sale.create', 'module' => 'pos'],
            ['name' => 'POS Sale Refund', 'slug' => 'pos.sale.refund', 'module' => 'pos'],
            ['name' => 'POS Receipts Read', 'slug' => 'pos.receipts.read', 'module' => 'pos'],
            ['name' => 'POS Reports', 'slug' => 'pos.reports.read', 'module' => 'pos'],
        ];

        foreach ($permissions as $permission) {
            Permission::query()->updateOrCreate(['slug' => $permission['slug']], $permission);
        }
    }
}
