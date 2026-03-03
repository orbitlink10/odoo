<?php

namespace App\Modules\Hospital\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Hospital\Models\Bill;
use App\Modules\Hospital\Models\HospitalPayment;

class ReportController extends Controller
{
    public function __invoke()
    {
        $dailyRevenue = (float) HospitalPayment::query()->whereDate('paid_at', now()->toDateString())->sum('amount');
        $unpaidBills = Bill::query()->where('balance', '>', 0)->with('patient')->latest()->limit(20)->get();

        return view('modules.hospital.reports', compact('dailyRevenue', 'unpaidBills'));
    }
}
