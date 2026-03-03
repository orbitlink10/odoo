<?php

namespace App\Modules\Property\Models;

use App\Models\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lease extends Model
{
    use BelongsToTenant;
    use HasFactory;

    protected $table = 'property_leases';

    protected $fillable = [
        'tenant_id',
        'unit_id',
        'rental_tenant_id',
        'start_date',
        'end_date',
        'rent_amount',
        'deposit_amount',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'rent_amount' => 'decimal:2',
            'deposit_amount' => 'decimal:2',
        ];
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }

    public function rentalTenant(): BelongsTo
    {
        return $this->belongsTo(RentalTenant::class, 'rental_tenant_id');
    }

    public function rentInvoices(): HasMany
    {
        return $this->hasMany(RentInvoice::class);
    }
}
