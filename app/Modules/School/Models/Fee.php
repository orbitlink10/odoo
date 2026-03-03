<?php

namespace App\Modules\School\Models;

use App\Models\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Fee extends Model
{
    use BelongsToTenant;
    use HasFactory;

    protected $table = 'school_fees';

    protected $fillable = ['tenant_id', 'class_id', 'name', 'term', 'amount', 'due_date'];

    protected function casts(): array
    {
        return [
            'due_date' => 'date',
            'amount' => 'decimal:2',
        ];
    }

    public function classRoom(): BelongsTo
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    public function feeInvoices(): HasMany
    {
        return $this->hasMany(FeeInvoice::class, 'fee_id');
    }
}
