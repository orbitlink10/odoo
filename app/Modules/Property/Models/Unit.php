<?php

namespace App\Modules\Property\Models;

use App\Models\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Unit extends Model
{
    use BelongsToTenant;
    use HasFactory;

    protected $table = 'property_units';

    protected $fillable = ['tenant_id', 'property_id', 'unit_no', 'rent_amount', 'status'];

    protected function casts(): array
    {
        return ['rent_amount' => 'decimal:2'];
    }

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

    public function leases(): HasMany
    {
        return $this->hasMany(Lease::class);
    }
}
