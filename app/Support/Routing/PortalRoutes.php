<?php

namespace App\Support\Routing;

use Closure;
use Illuminate\Support\Facades\Route;

final class PortalRoutes
{
    /**
     * Route publik TANPA prefix portal (mis. entry QR meja /q/{token}, webhook provider). Hanya
     * grup web — lapis tambahan (throttle, signature) dipasang per route oleh modul pemiliknya.
     */
    public static function web(Closure|string $routes): void
    {
        Route::middleware('web')->group($routes);
    }

    /** Portal pelanggan (publik, anonim). */
    public static function customer(Closure|string $routes): void
    {
        Route::middleware('web')
            ->prefix('kantin/{canteen}')
            ->name('customer.')
            ->group($routes);
    }

    /** Portal operator tenant (internal). */
    public static function tenant(Closure|string $routes): void
    {
        Route::middleware(['web', 'auth', 'verified', 'tenant'])
            ->prefix('tenant/{tenant:slug}')
            ->name('tenant.')
            ->scopeBindings()
            ->group($routes);
    }

    /** Portal pengelola kantin (internal). */
    public static function admin(Closure|string $routes): void
    {
        Route::middleware(['web', 'auth', 'verified', 'role:admin'])
            ->prefix('admin')
            ->name('admin.')
            ->group($routes);
    }
}
