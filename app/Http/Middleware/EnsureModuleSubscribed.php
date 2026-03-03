<?php

namespace App\Http\Middleware;

use App\Services\SubscriptionService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureModuleSubscribed
{
    public function __construct(private readonly SubscriptionService $subscriptionService)
    {
    }

    public function handle(Request $request, Closure $next, string $moduleSlug): Response
    {
        $user = $request->user();

        if (! $user || $user->is_super_admin) {
            return $next($request);
        }

        if (! $user->tenant || ! $this->subscriptionService->hasModuleAccess($user->tenant, $moduleSlug)) {
            return redirect()->route('billing.index')
                ->with('error', sprintf('Your subscription does not include %s.', ucfirst($moduleSlug)));
        }

        return $next($request);
    }
}
