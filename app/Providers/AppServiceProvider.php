<?php

namespace App\Providers;

use App\Models\Module;
use App\Services\AuditLogService;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(\App\Support\TenantContext::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->loadMigrationsFrom([
            app_path('Modules/School/database/migrations'),
            app_path('Modules/Hospital/database/migrations'),
            app_path('Modules/Property/database/migrations'),
            app_path('Modules/POS/database/migrations'),
        ]);

        Event::listen(Login::class, function (Login $event): void {
            if (! Schema::hasTable('audit_logs')) {
                return;
            }

            app(AuditLogService::class)->log(
                action: 'auth.login',
                entityType: 'user',
                entityId: $event->user->id,
                context: ['email' => $event->user->email]
            );
        });

        View::composer('*', function ($view): void {
            $modules = Schema::hasTable('modules')
                ? Module::query()->where('is_active', true)->orderBy('name')->get()
                : collect();

            $view->with('tiwiModules', $modules);
        });
    }
}
