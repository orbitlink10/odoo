<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\SubscriptionService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    public function __construct(private readonly SubscriptionService $subscriptionService)
    {
    }

    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended($this->resolveDefaultRedirect($request));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    private function resolveDefaultRedirect(Request $request): string
    {
        $user = $request->user();

        if (! $user) {
            return route('dashboard', absolute: false);
        }

        if ($user->is_super_admin) {
            return route('dashboard', absolute: false);
        }

        if (! $user->tenant) {
            return route('onboarding.create', absolute: false);
        }

        $subscription = $this->subscriptionService->currentForTenant($user->tenant);

        if (! $subscription) {
            return route('onboarding.create', absolute: false);
        }

        if (! $subscription->isAccessActive()) {
            return route('billing.index', absolute: false);
        }

        $moduleRoutes = [
            'school' => 'school.dashboard',
            'hospital' => 'hospital.dashboard',
            'property' => 'property.dashboard',
            'pos' => 'pos.dashboard',
        ];

        $enabledSlugs = $subscription->modules
            ->pluck('slug')
            ->filter()
            ->values();

        if ($enabledSlugs->count() === 1) {
            $onlyModule = (string) $enabledSlugs->first();

            if (isset($moduleRoutes[$onlyModule])) {
                return route($moduleRoutes[$onlyModule], absolute: false);
            }
        }

        return route('app.launcher', absolute: false);
    }
}
