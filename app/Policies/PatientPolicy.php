<?php

namespace App\Policies;

use App\Models\User;
use App\Modules\Hospital\Models\Patient;

class PatientPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermission('hospital.patients.read');
    }

    public function view(User $user, Patient $patient): bool
    {
        return $user->hasPermission('hospital.patients.read');
    }

    public function create(User $user): bool
    {
        return $user->hasPermission('hospital.patients.create');
    }

    public function update(User $user, Patient $patient): bool
    {
        return $user->hasPermission('hospital.patients.create');
    }

    public function delete(User $user, Patient $patient): bool
    {
        return $user->hasPermission('hospital.patients.create');
    }
}
