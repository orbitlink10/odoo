<?php

namespace App\Modules\Hospital\Models;

use App\Models\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HospitalPayment extends Model
{
    use BelongsToTenant;
    use HasFactory;

    protected $table = 'hospital_payments';

    protected $fillable = ['tenant_id', 'bill_id', 'amount', 'method', 'reference', 'paid_at'];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'paid_at' => 'datetime',
        ];
    }

    public function bill(): BelongsTo
    {
        return $this->belongsTo(Bill::class, 'bill_id');
    }
}
