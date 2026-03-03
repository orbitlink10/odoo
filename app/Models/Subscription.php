<?php

namespace App\Models;

use App\Models\Concerns\BelongsToTenant;
use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Subscription extends Model
{
    use BelongsToTenant;
    use HasFactory;

    public const STATUS_TRIALING = 'trialing';
    public const STATUS_ACTIVE = 'active';
    public const STATUS_PAST_DUE = 'past_due';
    public const STATUS_CANCELED = 'canceled';

    protected $fillable = [
        'tenant_id',
        'plan_id',
        'status',
        'starts_at',
        'ends_at',
        'trial_ends_at',
        'next_billing_at',
        'canceled_at',
        'meta',
    ];

    protected function casts(): array
    {
        return [
            'starts_at' => 'date',
            'ends_at' => 'date',
            'trial_ends_at' => 'date',
            'next_billing_at' => 'datetime',
            'canceled_at' => 'datetime',
            'meta' => 'array',
        ];
    }

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class);
    }

    public function modules(): BelongsToMany
    {
        return $this->belongsToMany(Module::class, 'subscription_module')
            ->withPivot('price')
            ->withTimestamps();
    }

    public function isAccessActive(?CarbonInterface $now = null): bool
    {
        $now = $now ?: now();

        if (! in_array($this->status, [self::STATUS_TRIALING, self::STATUS_ACTIVE], true)) {
            return false;
        }

        if ($this->status === self::STATUS_TRIALING && $this->trial_ends_at && $this->trial_ends_at->isPast()) {
            return false;
        }

        if ($this->ends_at && $this->ends_at->isBefore($now->toDateString())) {
            return false;
        }

        return true;
    }

    public function hasModule(string $moduleSlug): bool
    {
        return $this->modules->contains(fn (Module $module) => $module->slug === $moduleSlug);
    }
}
