<?php

namespace App\Modules\Property\Models;

use App\Models\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RentInvoice extends Model
{
    use BelongsToTenant;
    use HasFactory;

    protected $table = 'property_rent_invoices';

    protected $fillable = [
        'tenant_id',
        'lease_id',
        'invoice_no',
        'issue_date',
        'due_date',
        'amount',
        'paid_amount',
        'balance',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'issue_date' => 'date',
            'due_date' => 'date',
            'amount' => 'decimal:2',
            'paid_amount' => 'decimal:2',
            'balance' => 'decimal:2',
        ];
    }

    public function lease(): BelongsTo
    {
        return $this->belongsTo(Lease::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(PropertyPayment::class, 'rent_invoice_id');
    }
}
