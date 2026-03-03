<?php

namespace App\Modules\POS\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\POS\Models\Inventory;
use App\Modules\POS\Models\Product;
use App\Modules\POS\Models\Sale;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $today = now();
        $todayDate = $today->toDateString();
        $monthStart = $today->copy()->startOfMonth();
        $weekStart = $today->copy()->startOfWeek(Carbon::MONDAY);

        $todayTransactions = Sale::query()->whereDate('sold_at', $todayDate)->count();
        $todaySales = (float) Sale::query()->whereDate('sold_at', $todayDate)->sum('total');
        $monthToDateSales = (float) Sale::query()->whereBetween('sold_at', [$monthStart, $today])->sum('total');
        $weekToDateSales = (float) Sale::query()->whereBetween('sold_at', [$weekStart, $today])->sum('total');

        $lowStockCount = Inventory::query()->where('quantity', '>', 0)->where('quantity', '<=', 5)->count();
        $outOfStockCount = Inventory::query()->where('quantity', '<=', 0)->count();

        $yearSales = Sale::query()
            ->whereBetween('sold_at', [$today->copy()->startOfYear(), $today->copy()->endOfYear()])
            ->get()
            ->groupBy(fn (Sale $sale): string => $sale->sold_at->format('Y-m'));

        $monthlySummary = collect(range(1, 12))->map(function (int $month) use ($today, $yearSales): array {
            $key = $today->copy()->month($month)->format('Y-m');
            $sales = (float) $yearSales->get($key, collect())->sum('total');

            return [
                'month' => $today->copy()->month($month)->format('M'),
                'sales' => $sales,
                // Profit placeholder until product cost/COGS tracking is introduced.
                'profit' => 0.0,
            ];
        });

        return view('modules.pos.dashboard', [
            'productCount' => Product::query()->count(),
            'todaySales' => $todaySales,
            'todayTransactions' => $todayTransactions,
            'averageTicket' => $todayTransactions > 0 ? round($todaySales / $todayTransactions, 2) : 0,
            'monthToDateSales' => $monthToDateSales,
            'weekToDateSales' => $weekToDateSales,
            'todayProfit' => 0.0,
            'lowStockCount' => $lowStockCount,
            'outOfStockCount' => $outOfStockCount,
            'lowStockProducts' => Inventory::query()
                ->with('product')
                ->where('quantity', '<=', 5)
                ->orderBy('quantity')
                ->limit(6)
                ->get(),
            'recentSales' => Sale::query()
                ->with(['customer', 'user'])
                ->latest('sold_at')
                ->limit(8)
                ->get(),
            'monthlySummary' => $monthlySummary,
            'currentMonthLabel' => $today->format('F Y'),
            'todayLabel' => $todayDate,
        ]);
    }
}
