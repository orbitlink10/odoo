<?php

namespace App\Modules\Hospital\Models;

use App\Models\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Visit extends Model
{
    use BelongsToTenant;
    use HasFactory;

    protected $table = 'hospital_visits';

    protected $fillable = ['tenant_id', 'patient_id', 'appointment_id', 'visited_at', 'diagnosis', 'treatment'];

    protected function casts(): array
    {
        return ['visited_at' => 'datetime'];
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function appointment(): BelongsTo
    {
        return $this->belongsTo(Appointment::class);
    }
}
