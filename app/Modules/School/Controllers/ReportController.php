<?php

namespace App\Modules\School\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\School\Models\FeeInvoice;

class ReportController extends Controller
{
    public function __invoke()
    {
        $totalPaid = (float) FeeInvoice::query()->sum('paid_amount');
        $outstanding = (float) FeeInvoice::query()->sum('balance');
        $unpaidInvoices = FeeInvoice::query()->with('student')->where('balance', '>', 0)->latest()->limit(20)->get();

        return view('modules.school.reports', compact('totalPaid', 'outstanding', 'unpaidInvoices'));
    }
}
