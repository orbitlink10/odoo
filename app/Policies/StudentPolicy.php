<?php

namespace App\Policies;

use App\Models\User;
use App\Modules\School\Models\Student;

class StudentPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermission('school.students.read');
    }

    public function view(User $user, Student $student): bool
    {
        return $user->hasPermission('school.students.read');
    }

    public function create(User $user): bool
    {
        return $user->hasPermission('school.students.create');
    }

    public function update(User $user, Student $student): bool
    {
        return $user->hasPermission('school.students.create');
    }

    public function delete(User $user, Student $student): bool
    {
        return $user->hasPermission('school.students.create');
    }
}
