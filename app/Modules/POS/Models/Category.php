<?php

namespace App\Modules\POS\Models;

use App\Models\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use BelongsToTenant;
    use HasFactory;

    protected $table = 'pos_categories';

    protected $fillable = ['tenant_id', 'name'];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
