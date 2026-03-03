<?php

use App\Http\Controllers\Admin\InvoiceController as AdminInvoiceController;
use App\Http\Controllers\Admin\ModuleController as AdminModuleController;
use App\Http\Controllers\Admin\PlanController as AdminPlanController;
use App\Http\Controllers\Admin\SubscriptionController as AdminSubscriptionController;
use App\Http\Controllers\Admin\TenantController as AdminTenantController;
use App\Http\Controllers\Core\AppLauncherController;
use App\Http\Controllers\Core\BillingController;
use App\Http\Controllers\Core\MarketingController;
use App\Http\Controllers\Core\OnboardingController;
use App\Http\Controllers\Core\SettingsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TenantAdmin\RoleController as TenantRoleController;
use App\Http\Controllers\TenantAdmin\UserController as TenantUserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [MarketingController::class, 'home'])->name('home');
Route::get('/pricing', [MarketingController::class, 'pricing'])->name('pricing');
Route::get('/app/{landingSlug}', [MarketingController::class, 'appLanding'])
    ->whereIn('landingSlug', MarketingController::landingSlugs())
    ->name('marketing.app');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [AppLauncherController::class, 'index'])->name('dashboard');

    Route::get('/onboarding', [OnboardingController::class, 'create'])->name('onboarding.create');
    Route::post('/onboarding', [OnboardingController::class, 'store'])->name('onboarding.store');

    Route::prefix('app')->group(function () {
        Route::get('/', [AppLauncherController::class, 'index'])->name('app.launcher');
        Route::get('/settings', [SettingsController::class, 'edit'])->name('app.settings.edit')->middleware('subscription.active');
        Route::put('/settings', [SettingsController::class, 'update'])->name('app.settings.update')->middleware('subscription.active');

        Route::prefix('billing')->name('billing.')->middleware(['subscription.active'])->group(function () {
            Route::get('/', [BillingController::class, 'index'])->name('index');
            Route::post('/subscribe', [BillingController::class, 'subscribe'])->name('subscribe');
            Route::post('/pay', [BillingController::class, 'payInvoice'])->name('pay');
        });

        Route::prefix('school')
            ->name('school.')
            ->middleware(['subscription.active', 'module.subscribed:school'])
            ->group(base_path('app/Modules/School/routes/web.php'));

        Route::prefix('hospital')
            ->name('hospital.')
            ->middleware(['subscription.active', 'module.subscribed:hospital'])
            ->group(base_path('app/Modules/Hospital/routes/web.php'));

        Route::prefix('property')
            ->name('property.')
            ->middleware(['subscription.active', 'module.subscribed:property'])
            ->group(base_path('app/Modules/Property/routes/web.php'));

        Route::prefix('pos')
            ->name('pos.')
            ->middleware(['subscription.active', 'module.subscribed:pos'])
            ->group(base_path('app/Modules/POS/routes/web.php'));

        Route::prefix('super-admin')->name('admin.')->middleware(['subscription.active', 'permission:platform.super_admin.access'])->group(function () {
            Route::get('/tenants', [AdminTenantController::class, 'index'])->name('tenants.index');
            Route::get('/tenants/{tenant}', [AdminTenantController::class, 'show'])->name('tenants.show');
            Route::patch('/tenants/{tenant}/status', [AdminTenantController::class, 'updateStatus'])->name('tenants.status');

            Route::get('/modules', [AdminModuleController::class, 'index'])->name('modules.index');
            Route::post('/modules', [AdminModuleController::class, 'store'])->name('modules.store');

            Route::get('/plans', [AdminPlanController::class, 'index'])->name('plans.index');
            Route::post('/plans', [AdminPlanController::class, 'store'])->name('plans.store');

            Route::get('/subscriptions', [AdminSubscriptionController::class, 'index'])->name('subscriptions.index');
            Route::patch('/subscriptions/{subscription}/status', [AdminSubscriptionController::class, 'updateStatus'])->name('subscriptions.status');

            Route::get('/invoices', [AdminInvoiceController::class, 'index'])->name('invoices.index');
        });

        Route::prefix('tenant-admin')->name('tenant-admin.')->middleware(['subscription.active', 'permission:platform.tenant_admin.access'])->group(function () {
            Route::get('/users', [TenantUserController::class, 'index'])->name('users.index');
            Route::post('/users', [TenantUserController::class, 'store'])->name('users.store');
            Route::patch('/users/{user}', [TenantUserController::class, 'update'])->name('users.update');

            Route::get('/roles', [TenantRoleController::class, 'index'])->name('roles.index');
            Route::post('/roles', [TenantRoleController::class, 'store'])->name('roles.store');
            Route::patch('/roles/{role}', [TenantRoleController::class, 'update'])->name('roles.update');
        });
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
