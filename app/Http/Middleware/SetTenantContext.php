<?php

namespace App\Http\Middleware;

use App\Models\Tenant;
use App\Support\Tenancy\TenantContext;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetTenantContext
{
    public function handle(Request $request, Closure $next): Response
    {
        /** @var TenantContext $context */
        $context = app(TenantContext::class);

        /** @var Tenant|null $tenant */
        $tenant = $request->route('tenant');

        if ($tenant) {
            // Tolak dengan 403 bila tenant nonaktif
            if ($tenant->status !== 'active') {
                abort(403, 'Tenant tidak aktif atau tidak memiliki akses.');
            }

            $context->set($tenant->id);
        }

        try {
            return $next($request);
        } finally {
            // Bersihkan context agar nilainya tidak tertinggal
            $context->clear();
        }
    }
}
