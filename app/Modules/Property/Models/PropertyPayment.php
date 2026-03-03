<?php

namespace App\Modules\Property\Models;

use App\Models\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PropertyPayment extends Model
{
    use BelongsToTenant;
    use HasFactory;

    protected $table = 'property_payments';

    protected $fillable = ['tenant_id', 'rent_invoice_id', 'amount', 'method', 'reference', 'paid_at'];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'paid_at' => 'datetime',
        ];
    }

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(RentInvoice::class, 'rent_invoice_id');
    }
}
