<?php

namespace App\Modules\School\Models;

use App\Models\Concerns\BelongsToTenant;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Guardian extends Model
{
    use BelongsToTenant;
    use HasFactory;

    protected $table = 'school_guardians';

    protected $fillable = ['tenant_id', 'name', 'phone', 'email', 'relationship'];

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function students(): HasMany
    {
        return $this->hasMany(Student::class, 'guardian_id');
    }
}
