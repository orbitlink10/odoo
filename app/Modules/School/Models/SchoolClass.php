<?php

namespace App\Modules\School\Models;

use App\Models\Concerns\BelongsToTenant;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SchoolClass extends Model
{
    use BelongsToTenant;
    use HasFactory;

    protected $table = 'school_classes';

    protected $fillable = ['tenant_id', 'name', 'section', 'academic_year'];

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class, 'class_id');
    }
}
