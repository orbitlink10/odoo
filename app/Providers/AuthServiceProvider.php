<?php

namespace App\Providers;

use App\Modules\Hospital\Models\Patient;
use App\Modules\POS\Models\Product;
use App\Modules\Property\Models\Property;
use App\Modules\School\Models\Student;
use App\Policies\PatientPolicy;
use App\Policies\ProductPolicy;
use App\Policies\PropertyPolicy;
use App\Policies\StudentPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Student::class => StudentPolicy::class,
        Patient::class => PatientPolicy::class,
        Property::class => PropertyPolicy::class,
        Product::class => ProductPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();

        Gate::before(function ($user, $ability): ?bool {
            if ($user->is_super_admin) {
                return true;
            }

            return null;
        });
    }
}
