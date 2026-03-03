<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'monthly_price',
        'trial_days',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'monthly_price' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    public function modules(): BelongsToMany
    {
        return $this->belongsToMany(Module::class, 'plan_module')
            ->withPivot('price_override')
            ->withTimestamps();
    }
}
