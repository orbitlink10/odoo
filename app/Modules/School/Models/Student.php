<?php

namespace App\Modules\School\Models;

use App\Models\Concerns\BelongsToTenant;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use BelongsToTenant;
    use HasFactory;
    use SoftDeletes;

    protected $table = 'school_students';

    protected $fillable = [
        'tenant_id',
        'guardian_id',
        'admission_no',
        'first_name',
        'last_name',
        'date_of_birth',
        'gender',
        'status',
    ];

    protected function casts(): array
    {
        return ['date_of_birth' => 'date'];
    }

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function guardian(): BelongsTo
    {
        return $this->belongsTo(Guardian::class, 'guardian_id');
    }

    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class, 'student_id');
    }

    public function feeInvoices(): HasMany
    {
        return $this->hasMany(FeeInvoice::class, 'student_id');
    }

    public function getFullNameAttribute(): string
    {
        return trim($this->first_name.' '.$this->last_name);
    }
}
