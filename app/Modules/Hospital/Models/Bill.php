<?php

namespace App\Modules\Hospital\Models;

use App\Models\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Bill extends Model
{
    use BelongsToTenant;
    use HasFactory;

    protected $table = 'hospital_bills';

    protected $fillable = [
        'tenant_id',
        'patient_id',
        'bill_no',
        'issue_date',
        'total',
        'paid_amount',
        'balance',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'issue_date' => 'date',
            'total' => 'decimal:2',
            'paid_amount' => 'decimal:2',
            'balance' => 'decimal:2',
        ];
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(BillItem::class, 'bill_id');
    }

    public function payments(): HasMany
    {
        return $this->hasMany(HospitalPayment::class, 'bill_id');
    }
}
