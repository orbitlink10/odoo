<?php

namespace App\Services;

use App\Models\Subscription;
use App\Models\Tenant;

class SubscriptionService
{
    public function currentForTenant(Tenant $tenant): ?Subscription
    {
        return $tenant->subscriptions()->with('modules')->latest()->first();
    }

    public function isTenantActive(Tenant $tenant): bool
    {
        $subscription = $this->currentForTenant($tenant);

        return $subscription?->isAccessActive() ?? false;
    }

    public function hasModuleAccess(Tenant $tenant, string $moduleSlug): bool
    {
        $subscription = $this->currentForTenant($tenant);

        if (! $subscription || ! $subscription->isAccessActive()) {
            return false;
        }

        return $subscription->hasModule($moduleSlug);
    }
}
