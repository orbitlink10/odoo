<?php

namespace App\Modules\Property\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Property\Models\RentInvoice;
use App\Modules\Property\Models\Unit;

class ReportController extends Controller
{
    public function __invoke()
    {
        $arrears = RentInvoice::query()->with('lease.rentalTenant')->where('balance', '>', 0)->latest()->get();

        $totalUnits = Unit::query()->count();
        $occupiedUnits = Unit::query()->where('status', 'occupied')->count();
        $occupancyRate = $totalUnits > 0 ? round(($occupiedUnits / $totalUnits) * 100, 2) : 0;

        return view('modules.property.reports', compact('arrears', 'occupancyRate', 'totalUnits', 'occupiedUnits'));
    }
}
