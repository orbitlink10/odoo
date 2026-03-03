<?php

namespace App\Modules\POS\Models;

use App\Models\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    use BelongsToTenant;
    use HasFactory;

    protected $table = 'pos_customers';

    protected $fillable = ['tenant_id', 'name', 'phone', 'email'];

    public function sales(): HasMany
    {
        return $this->hasMany(Sale::class);
    }
}
