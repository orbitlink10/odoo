<?php

namespace App\Policies;

use App\Models\User;
use App\Modules\Property\Models\Property;

class PropertyPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermission('property.properties.read');
    }

    public function view(User $user, Property $property): bool
    {
        return $user->hasPermission('property.properties.read');
    }

    public function create(User $user): bool
    {
        return $user->hasPermission('property.properties.read');
    }

    public function update(User $user, Property $property): bool
    {
        return $user->hasPermission('property.properties.read');
    }

    public function delete(User $user, Property $property): bool
    {
        return $user->hasPermission('property.properties.read');
    }
}
