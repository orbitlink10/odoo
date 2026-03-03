<?php

namespace App\Modules\Property\Models;

use App\Models\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MaintenanceRequest extends Model
{
    use BelongsToTenant;
    use HasFactory;

    protected $table = 'property_maintenance_requests';

    protected $fillable = ['tenant_id', 'unit_id', 'title', 'description', 'status', 'priority'];

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }
}
