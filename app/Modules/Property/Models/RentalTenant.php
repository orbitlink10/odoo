<?php

namespace App\Modules\Property\Models;

use App\Models\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RentalTenant extends Model
{
    use BelongsToTenant;
    use HasFactory;

    protected $table = 'property_tenants';

    protected $fillable = ['tenant_id', 'name', 'phone', 'email', 'id_number'];

    public function leases(): HasMany
    {
        return $this->hasMany(Lease::class, 'rental_tenant_id');
    }
}
