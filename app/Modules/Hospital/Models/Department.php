<?php

namespace App\Modules\Hospital\Models;

use App\Models\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Department extends Model
{
    use BelongsToTenant;
    use HasFactory;

    protected $table = 'hospital_departments';

    protected $fillable = ['tenant_id', 'name', 'code'];

    public function doctors(): HasMany
    {
        return $this->hasMany(Doctor::class, 'department_id');
    }
}
