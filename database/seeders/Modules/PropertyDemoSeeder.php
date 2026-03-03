<?php

namespace Database\Seeders\Modules;

use App\Models\Tenant;
use App\Modules\Property\Models\Lease;
use App\Modules\Property\Models\MaintenanceRequest;
use App\Modules\Property\Models\Property;
use App\Modules\Property\Models\PropertyPayment;
use App\Modules\Property\Models\RentalTenant;
use App\Modules\Property\Models\RentInvoice;
use App\Modules\Property\Models\Unit;
use Illuminate\Database\Seeder;

class PropertyDemoSeeder extends Seeder
{
    public function run(): void
    {
        $tenant = Tenant::query()->where('slug', 'demo-campus')->first();

        if (! $tenant) {
            return;
        }

        $property = Property::query()->withoutGlobalScope('tenant')->firstOrCreate(
            ['tenant_id' => $tenant->id, 'name' => 'Sunrise Apartments'],
            ['type' => 'residential', 'location' => 'Nairobi West']
        );

        $unit = Unit::query()->withoutGlobalScope('tenant')->firstOrCreate(
            ['tenant_id' => $tenant->id, 'property_id' => $property->id, 'unit_no' => 'A1'],
            ['rent_amount' => 25000, 'status' => 'occupied']
        );

        $rentalTenant = RentalTenant::query()->withoutGlobalScope('tenant')->firstOrCreate(
            ['tenant_id' => $tenant->id, 'name' => 'Mercy Wanjiru'],
            ['phone' => '+254700555666', 'email' => 'mercy@example.com']
        );

        $lease = Lease::query()->withoutGlobalScope('tenant')->firstOrCreate(
            ['tenant_id' => $tenant->id, 'unit_id' => $unit->id, 'rental_tenant_id' => $rentalTenant->id],
            ['start_date' => now()->subMonths(2)->toDateString(), 'rent_amount' => 25000, 'deposit_amount' => 25000, 'status' => 'active']
        );

        $invoice = RentInvoice::query()->withoutGlobalScope('tenant')->firstOrCreate(
            ['tenant_id' => $tenant->id, 'invoice_no' => 'RI-DEMO-001'],
            [
                'lease_id' => $lease->id,
                'issue_date' => now()->startOfMonth()->toDateString(),
                'due_date' => now()->startOfMonth()->addDays(5)->toDateString(),
                'amount' => 25000,
                'paid_amount' => 15000,
                'balance' => 10000,
                'status' => 'partial',
            ]
        );

        PropertyPayment::query()->withoutGlobalScope('tenant')->firstOrCreate(
            ['tenant_id' => $tenant->id, 'rent_invoice_id' => $invoice->id, 'amount' => 15000],
            ['method' => 'bank', 'paid_at' => now()]
        );

        MaintenanceRequest::query()->withoutGlobalScope('tenant')->firstOrCreate(
            ['tenant_id' => $tenant->id, 'title' => 'Water leakage kitchen'],
            ['unit_id' => $unit->id, 'description' => 'Leak under sink', 'status' => 'open', 'priority' => 'high']
        );
    }
}
