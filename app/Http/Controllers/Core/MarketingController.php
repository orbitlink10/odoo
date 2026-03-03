<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class MarketingController extends Controller
{
    public function home()
    {
        $plans = Schema::hasTable('plans')
            ? Plan::query()->where('is_active', true)->orderBy('monthly_price')->get()
            : collect();

        return view('marketing.home', compact('plans'));
    }

    public function pricing()
    {
        $plans = Schema::hasTable('plans')
            ? Plan::query()->with('modules')->where('is_active', true)->orderBy('monthly_price')->get()
            : collect();

        return view('marketing.pricing', compact('plans'));
    }

    public function appLanding(Request $request, string $landingSlug)
    {
        $pages = $this->appPages();
        abort_unless(isset($pages[$landingSlug]), 404);

        $page = $pages[$landingSlug];

        if ($request->user()) {
            return redirect('/app/'.$page['module']);
        }

        return view('marketing.app-landing', [
            'page' => $page,
            'landingSlug' => $landingSlug,
        ]);
    }

    public static function landingSlugs(): array
    {
        return array_keys(self::appPagesStatic());
    }

    private function appPages(): array
    {
        return self::appPagesStatic();
    }

    private static function appPagesStatic(): array
    {
        return [
            'school-management' => [
                'module' => 'school',
                'title' => 'School Management',
                'hero' => 'School made simple',
                'accent' => '#23bfa7',
                'description' => 'Student records, class management, fee invoicing, payment tracking, and outstanding reports in one streamlined system.',
                'menu' => ['Admissions', 'Fees', 'Reports', 'Features'],
            ],
            'hospital-management' => [
                'module' => 'hospital',
                'title' => 'Hospital Management',
                'hero' => 'Hospital care, organized',
                'accent' => '#23bfa7',
                'description' => 'Patients, appointments, visits, billing, and unpaid bill reports built for fast, reliable clinical operations.',
                'menu' => ['Patients', 'Billing', 'Departments', 'Features'],
            ],
            'property-management' => [
                'module' => 'property',
                'title' => 'Property Management',
                'hero' => 'Property operations in one view',
                'accent' => '#23bfa7',
                'description' => 'Manage properties, units, leases, rent invoices, arrears, occupancy, and maintenance workflows from a single dashboard.',
                'menu' => ['Leasing', 'Rent', 'Maintenance', 'Features'],
            ],
            'point-of-sale-shop' => [
                'module' => 'pos',
                'title' => 'Point of Sale',
                'hero' => 'PoS made for retail',
                'accent' => '#23bfa7',
                'description' => 'A reliable Point of Sale for modern retailers. Inventory, promotions, receipts, and daily sales reports in one platform.',
                'menu' => ['Shop', 'Inventory', 'Receipts', 'Features'],
            ],
        ];
    }
}
