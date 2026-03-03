<?php

namespace App\Modules\Hospital\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Hospital\Models\Appointment;
use App\Modules\Hospital\Models\Bill;
use App\Modules\Hospital\Models\HospitalPayment;
use App\Modules\Hospital\Models\Patient;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $today = now()->toDateString();

        return view('modules.hospital.dashboard', [
            'patientCount' => Patient::query()->count(),
            'appointmentsToday' => Appointment::query()->whereDate('appointment_at', $today)->count(),
            'unpaidBills' => (float) Bill::query()->sum('balance'),
            'todayRevenue' => (float) HospitalPayment::query()->whereDate('paid_at', $today)->sum('amount'),
            'pendingBillCount' => Bill::query()->where('balance', '>', 0)->count(),
            'upcomingAppointments' => Appointment::query()
                ->with('patient')
                ->where('appointment_at', '>=', now())
                ->orderBy('appointment_at')
                ->limit(6)
                ->get(),
            'recentPatients' => Patient::query()->latest()->limit(6)->get(),
        ]);
    }
}
