<?php

namespace App\Modules\School\Models;

use App\Models\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FeeInvoice extends Model
{
    use BelongsToTenant;
    use HasFactory;

    protected $table = 'school_fee_invoices';

    protected $fillable = [
        'tenant_id',
        'student_id',
        'fee_id',
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

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function fee(): BelongsTo
    {
        return $this->belongsTo(Fee::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(SchoolPayment::class, 'fee_invoice_id');
    }
}
