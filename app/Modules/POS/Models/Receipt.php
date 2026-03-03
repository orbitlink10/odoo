<?php

namespace App\Modules\POS\Models;

use App\Models\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Receipt extends Model
{
    use BelongsToTenant;
    use HasFactory;

    protected $table = 'pos_receipts';

    protected $fillable = ['tenant_id', 'sale_id', 'receipt_no', 'notes'];

    public function sale(): BelongsTo
    {
        return $this->belongsTo(Sale::class);
    }
}
