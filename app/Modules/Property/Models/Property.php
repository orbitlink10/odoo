<?php

namespace App\Modules\Property\Models;

use App\Models\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Property extends Model
{
    use BelongsToTenant;
    use HasFactory;
    use SoftDeletes;

    protected $table = 'property_properties';

    protected $fillable = ['tenant_id', 'name', 'type', 'location'];

    public function units(): HasMany
    {
        return $this->hasMany(Unit::class);
    }
}
