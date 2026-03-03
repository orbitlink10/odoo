<?php

namespace App\Modules\Property\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Property\Models\Lease;
use App\Modules\Property\Models\MaintenanceRequest;
use App\Modules\Property\Models\Property;
use App\Modules\Property\Models\RentInvoice;
use App\Modules\Property\Models\Unit;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $totalUnits = Unit::query()->count();
        $occupiedUnits = Unit::query()->where('status', 'occupied')->count();
        $occupancyRate = $totalUnits > 0 ? round(($occupiedUnits / $totalUnits) * 100, 2) : 0;

        return view('modules.property.dashboard', [
            'propertyCount' => Property::query()->count(),
            'totalUnits' => $totalUnits,
            'occupiedUnits' => $occupiedUnits,
            'occupancyRate' => $occupancyRate,
            'arrearsTotal' => (float) RentInvoice::query()->sum('balance'),
            'openMaintenanceCount' => MaintenanceRequest::query()->where('status', '!=', 'closed')->count(),
            'expiringLeases' => Lease::query()
                ->with(['unit', 'rentalTenant'])
                ->whereNotNull('end_date')
                ->whereBetween('end_date', [now()->toDateString(), now()->addDays(45)->toDateString()])
                ->orderBy('end_date')
                ->limit(6)
                ->get(),
            'recentRentInvoices' => RentInvoice::query()
                ->with('lease.rentalTenant')
                ->latest()
                ->limit(6)
                ->get(),
        ]);
    }
}
