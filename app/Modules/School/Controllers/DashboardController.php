<?php

namespace App\Modules\School\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\School\Models\FeeInvoice;
use App\Modules\School\Models\SchoolClass;
use App\Modules\School\Models\SchoolPayment;
use App\Modules\School\Models\Student;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $today = now()->startOfDay();
        $weekStart = now()->startOfWeek();
        $weekEnd = now()->endOfWeek();
        $monthStart = now()->startOfMonth();
        $monthEnd = now()->endOfMonth();
        $currentYear = (int) now()->year;

        $totalBilled = (float) FeeInvoice::query()->sum('amount');
        $totalCollected = (float) FeeInvoice::query()->sum('paid_amount');
        $invoiceOutstanding = (float) FeeInvoice::query()->sum('balance');
        $collectionRate = $totalBilled > 0 ? round(($totalCollected / $totalBilled) * 100, 2) : 0;
        $overdueInvoicesCount = FeeInvoice::query()
            ->where('balance', '>', 0)
            ->whereDate('due_date', '<', $today->toDateString())
            ->count();
        $dueThisWeekAmount = (float) FeeInvoice::query()
            ->where('balance', '>', 0)
            ->whereDate('due_date', '>=', $today->toDateString())
            ->whereDate('due_date', '<=', $today->copy()->addDays(7)->toDateString())
            ->sum('balance');
        $newStudentsThisMonth = Student::query()
            ->whereBetween('created_at', [$monthStart, $monthEnd])
            ->count();
        $monthCollections = (float) SchoolPayment::query()
            ->whereBetween('paid_at', [$monthStart, $monthEnd])
            ->sum('amount');
        $todayCollections = (float) SchoolPayment::query()
            ->whereDate('paid_at', $today->toDateString())
            ->sum('amount');
        $weekCollections = (float) SchoolPayment::query()
            ->whereBetween('paid_at', [$weekStart, $weekEnd])
            ->sum('amount');
        $todayAdmissions = Student::query()
            ->whereDate('created_at', $today->toDateString())
            ->count();
        $monthlySummary = collect(range(1, 12))
            ->map(function (int $month) use ($currentYear) {
                $start = Carbon::create($currentYear, $month, 1)->startOfMonth();
                $end = $start->copy()->endOfMonth();

                return [
                    'month' => $start->format('M'),
                    'billed' => (float) FeeInvoice::query()
                        ->whereBetween('issue_date', [$start->toDateString(), $end->toDateString()])
                        ->sum('amount'),
                    'collected' => (float) SchoolPayment::query()
                        ->whereBetween('paid_at', [$start, $end])
                        ->sum('amount'),
                ];
            })
            ->all();

        return view('modules.school.dashboard', [
            'studentCount' => Student::query()->count(),
            'classCount' => SchoolClass::query()->count(),
            'invoiceOutstanding' => $invoiceOutstanding,
            'totalBilled' => $totalBilled,
            'totalCollected' => $totalCollected,
            'collectionRate' => $collectionRate,
            'overdueInvoicesCount' => $overdueInvoicesCount,
            'dueThisWeekAmount' => $dueThisWeekAmount,
            'newStudentsThisMonth' => $newStudentsThisMonth,
            'monthCollections' => $monthCollections,
            'todayCollections' => $todayCollections,
            'weekCollections' => $weekCollections,
            'todayAdmissions' => $todayAdmissions,
            'currentMonthLabel' => now()->format('F Y'),
            'monthlySummary' => $monthlySummary,
            'recentStudents' => Student::query()->latest()->limit(5)->get(),
            'dueInvoices' => FeeInvoice::query()
                ->with('student')
                ->where('balance', '>', 0)
                ->orderBy('due_date')
                ->limit(6)
                ->get(),
        ]);
    }
}
