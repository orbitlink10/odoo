<?php

namespace Database\Seeders\Modules;

use App\Models\Tenant;
use App\Modules\School\Models\Fee;
use App\Modules\School\Models\FeeInvoice;
use App\Modules\School\Models\Guardian;
use App\Modules\School\Models\SchoolClass;
use App\Modules\School\Models\SchoolPayment;
use App\Modules\School\Models\Student;
use Illuminate\Database\Seeder;

class SchoolDemoSeeder extends Seeder
{
    public function run(): void
    {
        $tenant = Tenant::query()->where('slug', 'demo-campus')->first();

        if (! $tenant) {
            return;
        }

        $class = SchoolClass::query()->withoutGlobalScope('tenant')->firstOrCreate(
            ['tenant_id' => $tenant->id, 'name' => 'Grade 6', 'section' => 'A'],
            ['academic_year' => '2026']
        );

        $guardian = Guardian::query()->withoutGlobalScope('tenant')->firstOrCreate(
            ['tenant_id' => $tenant->id, 'name' => 'Jane Guardian'],
            ['phone' => '+254700111222', 'email' => 'guardian@example.com', 'relationship' => 'Mother']
        );

        $student = Student::query()->withoutGlobalScope('tenant')->firstOrCreate(
            ['tenant_id' => $tenant->id, 'admission_no' => 'ADM-001'],
            [
                'guardian_id' => $guardian->id,
                'first_name' => 'Brian',
                'last_name' => 'Otieno',
                'date_of_birth' => '2014-05-12',
                'gender' => 'male',
                'status' => 'active',
            ]
        );

        $fee = Fee::query()->withoutGlobalScope('tenant')->firstOrCreate(
            ['tenant_id' => $tenant->id, 'name' => 'Term 1 Tuition'],
            ['class_id' => $class->id, 'term' => 'Term 1', 'amount' => 12000, 'due_date' => now()->addDays(14)->toDateString()]
        );

        $invoice = FeeInvoice::query()->withoutGlobalScope('tenant')->firstOrCreate(
            ['tenant_id' => $tenant->id, 'invoice_no' => 'SFI-DEMO-001'],
            [
                'student_id' => $student->id,
                'fee_id' => $fee->id,
                'issue_date' => now()->toDateString(),
                'due_date' => now()->addDays(14)->toDateString(),
                'amount' => 12000,
                'paid_amount' => 7000,
                'balance' => 5000,
                'status' => 'partial',
            ]
        );

        SchoolPayment::query()->withoutGlobalScope('tenant')->firstOrCreate(
            ['tenant_id' => $tenant->id, 'fee_invoice_id' => $invoice->id, 'amount' => 7000],
            ['method' => 'mpesa', 'reference' => 'MPESA123', 'paid_at' => now()]
        );
    }
}
