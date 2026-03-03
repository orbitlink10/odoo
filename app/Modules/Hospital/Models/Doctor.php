<?php

namespace App\Modules\Hospital\Models;

use App\Models\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Doctor extends Model
{
    use BelongsToTenant;
    use HasFactory;

    protected $table = 'hospital_doctors';

    protected $fillable = ['tenant_id', 'department_id', 'name', 'specialization', 'phone', 'email'];

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }
}
