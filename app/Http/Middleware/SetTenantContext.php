<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetTenantContext
{
    public function handle(Request $request, Closure $next)
    {
        $context = app(TenantContext::class);
        $tenant = $request->route('tenant');

        if ($tenant) {
            if ($tenant->status !== active) {
                abort(403, 'Tenant tidak aktif atau tidak memiliki akses.');
            }

            $context->set($tenant->id);
        }

        try {
            return $next($request);
        } finally {
            $context->clear();
        }
    }
}
