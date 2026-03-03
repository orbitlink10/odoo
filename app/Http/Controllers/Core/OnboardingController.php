<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use App\Http\Requests\Core\StoreOnboardingRequest;
use App\Models\Module;
use App\Models\Role;
use App\Models\Tenant;
use App\Services\AuditLogService;
use App\Services\BillingService;
use App\Services\SubscriptionService;
use Illuminate\Support\Str;

class OnboardingController extends Controller
{
    public function __construct(
        private readonly BillingService $billingService,
        private readonly AuditLogService $auditLogService,
        private readonly SubscriptionService $subscriptionService,
    ) {
    }

    public function create()
    {
        $user = request()->user();

        if ($user?->tenant) {
            $subscription = $this->subscriptionService->currentForTenant($user->tenant);

            if ($subscription && $subscription->isAccessActive()) {
                $moduleRoutes = [
                    'school' => 'school.dashboard',
                    'hospital' => 'hospital.dashboard',
                    'property' => 'property.dashboard',
                    'pos' => 'pos.dashboard',
                ];

                $enabledModules = $subscription->modules
                    ->pluck('slug')
                    ->filter()
                    ->values();

                if ($enabledModules->count() === 1) {
                    $module = (string) $enabledModules->first();

                    if (isset($moduleRoutes[$module])) {
                        return redirect()->route($moduleRoutes[$module]);
                    }
                }

                return redirect()->route('app.launcher');
            }

            return redirect()->route('billing.index');
        }

        $modules = Module::query()->where('is_active', true)->orderBy('name')->get();
        $selectedModule = request()->query('module');
        $prefill = [
            'company_name' => trim((string) request()->query('company_name')),
            'admin_phone' => trim((string) request()->query('admin_phone')),
        ];

        if (! in_array($selectedModule, ['school', 'hospital', 'property', 'pos'], true)) {
            $selectedModule = null;
        }

        return view('onboarding.create', compact('modules', 'selectedModule', 'prefill'));
    }

    public function store(StoreOnboardingRequest $request)
    {
        $user = $request->user();
        $lockedModule = $request->validated('locked_module');
        $selectedModules = $lockedModule
            ? [$lockedModule]
            : $request->validated('modules');

        $schoolProfile = null;

        if (in_array('school', $selectedModules, true)) {
            $schoolProfile = [
                'registration_number' => $request->validated('school_registration_number'),
                'school_type' => $request->validated('school_type'),
                'admission_term' => $request->validated('admission_term'),
                'student_capacity' => $request->filled('student_capacity')
                    ? (int) $request->validated('student_capacity')
                    : null,
                'academic_year_start' => $request->validated('academic_year_start'),
                'fee_due_day' => $request->filled('fee_due_day')
                    ? (int) $request->validated('fee_due_day')
                    : null,
                'fee_reminder_email' => $request->boolean('fee_reminder_email', true),
                'fee_reminder_sms' => $request->boolean('fee_reminder_sms', false),
            ];
        }

        $tenant = Tenant::query()->create([
            'name' => $request->validated('company_name'),
            'slug' => Str::slug($request->validated('company_name')).'-'.Str::lower(Str::random(5)),
            'country' => strtoupper($request->validated('country')),
            'timezone' => $request->validated('timezone'),
            'currency' => strtoupper($request->validated('currency')),
            'settings' => [
                'sms_provider' => null,
                'email_provider' => null,
                'vat_rate' => 16,
                'school_profile' => $schoolProfile,
            ],
        ]);

        $user->update([
            'tenant_id' => $tenant->id,
            'name' => $request->validated('admin_name'),
            'email' => $request->validated('admin_email'),
            'phone' => $request->validated('admin_phone'),
        ]);

        $tenantAdminRole = Role::query()
            ->whereNull('tenant_id')
            ->where('slug', 'tenant-admin')
            ->first();

        if ($tenantAdminRole) {
            $user->roles()->syncWithoutDetaching([$tenantAdminRole->id]);
        }

        $subscription = $this->billingService->createOrUpdateSubscription(
            tenant: $tenant,
            moduleSlugs: $selectedModules,
            planId: null,
            startTrial: (bool) $request->boolean('start_trial', true),
            trialDays: (int) $request->integer('trial_days', 14),
        );

        $this->billingService->generateInvoiceForSubscription($subscription);

        $this->auditLogService->log('tenant.onboarded', Tenant::class, $tenant->id, [
            'modules' => $selectedModules,
            'school_profile' => $schoolProfile,
            'subscription_id' => $subscription->id,
        ]);

        $moduleRoutes = [
            'school' => 'school.dashboard',
            'hospital' => 'hospital.dashboard',
            'property' => 'property.dashboard',
            'pos' => 'pos.dashboard',
        ];

        if (count($selectedModules) === 1) {
            $onlyModule = $selectedModules[0] ?? null;

            if ($onlyModule && isset($moduleRoutes[$onlyModule])) {
                return redirect()->route($moduleRoutes[$onlyModule])
                    ->with('success', 'Tenant onboarding completed.');
            }
        }

        return redirect()->route('app.launcher')->with('success', 'Tenant onboarding completed.');
    }
}
