<?php

namespace App\Policies;

use App\Models\User;
use App\Modules\POS\Models\Product;

class ProductPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermission('pos.products.read');
    }

    public function view(User $user, Product $product): bool
    {
        return $user->hasPermission('pos.products.read');
    }

    public function create(User $user): bool
    {
        return $user->hasPermission('pos.products.read');
    }

    public function update(User $user, Product $product): bool
    {
        return $user->hasPermission('pos.products.read');
    }

    public function delete(User $user, Product $product): bool
    {
        return $user->hasPermission('pos.products.read');
    }
}
