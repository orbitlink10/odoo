<?php

namespace App\Http\Middleware;

use App\Support\TenantContext;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ResolveTenantContext
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && ! $user->is_super_admin && $user->tenant_id) {
            app(TenantContext::class)->setTenantId($user->tenant_id);
        } else {
            app(TenantContext::class)->setTenantId(null);
        }

        return $next($request);
    }
}
