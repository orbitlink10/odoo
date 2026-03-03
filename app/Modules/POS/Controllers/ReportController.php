<?php

namespace App\Modules\POS\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\POS\Models\Sale;

class ReportController extends Controller
{
    public function __invoke()
    {
        $todaySales = Sale::query()->whereDate('sold_at', now()->toDateString())->with('items.product')->get();
        $gross = (float) $todaySales->sum('total');

        return view('modules.pos.reports', [
            'todaySales' => $todaySales,
            'gross' => $gross,
        ]);
    }
}
