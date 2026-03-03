<?php

namespace Database\Seeders\Core;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roleMatrix = [
            'super-admin' => [
                'name' => 'Super Admin',
                'permissions' => Permission::query()->pluck('slug')->all(),
            ],
            'tenant-admin' => [
                'name' => 'Tenant Admin',
                'permissions' => Permission::query()
                    ->whereNot('slug', 'platform.super_admin.access')
                    ->pluck('slug')
                    ->all(),
            ],
            'manager' => [
                'name' => 'Manager',
                'permissions' => Permission::query()
                    ->whereIn('module', ['school', 'hospital', 'property', 'pos'])
                    ->pluck('slug')
                    ->all(),
            ],
            'staff' => [
                'name' => 'Staff',
                'permissions' => [
                    'school.students.read',
                    'hospital.patients.read',
                    'property.properties.read',
                    'property.units.read',
                ],
            ],
            'accountant' => [
                'name' => 'Accountant',
                'permissions' => [
                    'platform.billing.manage',
                    'school.fees.read',
                    'school.fees.pay',
                    'hospital.bills.read',
                    'hospital.bills.pay',
                    'property.rent.read',
                    'property.rent.collect',
                    'pos.reports.read',
                ],
            ],
            'cashier' => [
                'name' => 'Cashier',
                'permissions' => [
                    'pos.products.read',
                    'pos.sale.create',
                    'pos.receipts.read',
                ],
            ],
        ];

        foreach ($roleMatrix as $slug => $data) {
            $role = Role::query()->updateOrCreate(
                ['tenant_id' => null, 'slug' => $slug],
                ['name' => $data['name'], 'scope' => 'system']
            );

            $permissionIds = Permission::query()->whereIn('slug', $data['permissions'])->pluck('id');
            $role->permissions()->sync($permissionIds);
        }
    }
}
