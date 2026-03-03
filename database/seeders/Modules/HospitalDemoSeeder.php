<?php

namespace Database\Seeders\Modules;

use App\Models\Tenant;
use App\Modules\Hospital\Models\Bill;
use App\Modules\Hospital\Models\BillItem;
use App\Modules\Hospital\Models\Department;
use App\Modules\Hospital\Models\Doctor;
use App\Modules\Hospital\Models\HospitalPayment;
use App\Modules\Hospital\Models\Patient;
use Illuminate\Database\Seeder;

class HospitalDemoSeeder extends Seeder
{
    public function run(): void
    {
        $tenant = Tenant::query()->where('slug', 'demo-campus')->first();

        if (! $tenant) {
            return;
        }

        $dept = Department::query()->withoutGlobalScope('tenant')->firstOrCreate(
            ['tenant_id' => $tenant->id, 'name' => 'General Medicine'],
            ['code' => 'GM']
        );

        Doctor::query()->withoutGlobalScope('tenant')->firstOrCreate(
            ['tenant_id' => $tenant->id, 'name' => 'Dr. Alice Mugo'],
            ['department_id' => $dept->id, 'specialization' => 'General Physician']
        );

        $patient = Patient::query()->withoutGlobalScope('tenant')->firstOrCreate(
            ['tenant_id' => $tenant->id, 'patient_no' => 'PAT-001'],
            ['first_name' => 'John', 'last_name' => 'Kamau', 'phone' => '+254700333444']
        );

        $bill = Bill::query()->withoutGlobalScope('tenant')->firstOrCreate(
            ['tenant_id' => $tenant->id, 'bill_no' => 'HB-DEMO-001'],
            [
                'patient_id' => $patient->id,
                'issue_date' => now()->toDateString(),
                'total' => 3500,
                'paid_amount' => 2000,
                'balance' => 1500,
                'status' => 'partial',
            ]
        );

        BillItem::query()->firstOrCreate(
            ['bill_id' => $bill->id, 'description' => 'Consultation'],
            ['quantity' => 1, 'unit_price' => 3500, 'line_total' => 3500]
        );

        HospitalPayment::query()->withoutGlobalScope('tenant')->firstOrCreate(
            ['tenant_id' => $tenant->id, 'bill_id' => $bill->id, 'amount' => 2000],
            ['method' => 'cash', 'paid_at' => now()]
        );
    }
}
