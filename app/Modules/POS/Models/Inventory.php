<?php

namespace App\Modules\POS\Models;

use App\Models\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Inventory extends Model
{
    use BelongsToTenant;
    use HasFactory;

    protected $table = 'pos_inventories';

    protected $fillable = ['tenant_id', 'product_id', 'quantity'];

    protected function casts(): array
    {
        return ['quantity' => 'decimal:2'];
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
