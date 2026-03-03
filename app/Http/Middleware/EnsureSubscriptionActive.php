<?php

namespace App\Http\Middleware;

use App\Services\SubscriptionService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureSubscriptionActive
{
    public function __construct(private readonly SubscriptionService $subscriptionService)
    {
    }

    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user || $user->is_super_admin) {
            return $next($request);
        }

        if (! $user->tenant) {
            return redirect()->route('onboarding.create');
        }

        if (! $this->subscriptionService->isTenantActive($user->tenant)) {
            if ($request->routeIs('app.launcher')) {
                return $next($request);
            }

            if (! $request->routeIs('billing.*')) {
                return redirect()->route('billing.index')
                    ->with('error', 'Your subscription is inactive. Please update billing to continue.');
            }
        }

        return $next($request);
    }
}
