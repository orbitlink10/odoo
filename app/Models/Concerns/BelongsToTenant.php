<?php

namespace App\Models\Concerns;

use App\Support\TenantContext;
use Illuminate\Database\Eloquent\Builder;

trait BelongsToTenant
{
    public static function bootBelongsToTenant(): void
    {
        static::addGlobalScope('tenant', function (Builder $builder): void {
            $tenantId = app(TenantContext::class)->id();

            if ($tenantId !== null) {
                $builder->where($builder->getModel()->getTable().'.tenant_id', $tenantId);
            }
        });

        static::creating(function ($model): void {
            if (! isset($model->tenant_id)) {
                $tenantId = app(TenantContext::class)->id();

                if ($tenantId !== null) {
                    $model->tenant_id = $tenantId;
                }
            }
        });
    }

    public function scopeForTenant(Builder $query, int $tenantId): Builder
    {
        return $query->withoutGlobalScope('tenant')->where($this->getTable().'.tenant_id', $tenantId);
    }
}
