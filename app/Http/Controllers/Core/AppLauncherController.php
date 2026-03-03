<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use App\Models\Module;
use App\Modules\Hospital\Models\Appointment;
use App\Modules\Hospital\Models\Patient;
use App\Modules\POS\Models\Product;
use App\Modules\POS\Models\Sale;
use App\Modules\Property\Models\Property;
use App\Modules\Property\Models\Unit;
use App\Modules\School\Models\SchoolClass;
use App\Modules\School\Models\Student;
use App\Services\SubscriptionService;
use Illuminate\Http\Request;

class AppLauncherController extends Controller
{
    public function __construct(private readonly SubscriptionService $subscriptionService)
    {
    }

    public function index(Request $request)
    {
        $user = $request->user();
        $tenant = $user?->tenant;

        $allModules = Module::query()->where('is_active', true)->orderBy('name')->get();
        $subscription = $tenant ? $this->subscriptionService->currentForTenant($tenant) : null;
        $enabledModuleSlugs = $subscription?->modules?->pluck('slug')->all() ?? [];
        $subscriptionActive = $tenant ? $this->subscriptionService->isTenantActive($tenant) : false;
        $moduleInsights = [
            'school' => [
                'primary' => Student::query()->count().' students',
                'secondary' => SchoolClass::query()->count().' classes',
            ],
            'hospital' => [
                'primary' => Patient::query()->count().' patients',
                'secondary' => Appointment::query()->whereDate('appointment_at', now()->toDateString())->count().' appointments today',
            ],
            'property' => [
                'primary' => Property::query()->count().' properties',
                'secondary' => Unit::query()->count().' units tracked',
            ],
            'pos' => [
                'primary' => Product::query()->count().' products',
                'secondary' => 'KES '.number_format((float) Sale::query()->whereDate('sold_at', now()->toDateString())->sum('total'), 2).' sold today',
            ],
        ];

        return view('app.launcher', [
            'tenant' => $tenant,
            'modules' => $allModules,
            'enabledModuleSlugs' => $enabledModuleSlugs,
            'subscription' => $subscription,
            'subscriptionActive' => $subscriptionActive,
            'moduleInsights' => $moduleInsights,
        ]);
    }
}
