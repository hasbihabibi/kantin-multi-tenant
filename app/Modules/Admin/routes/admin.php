<?php

use App\Modules\Admin\Http\Controllers\AdminTenantBankController;
use App\Modules\Admin\Http\Controllers\AdminTenantCommissionController;
use App\Modules\Admin\Http\Controllers\AdminTenantController;
use App\Modules\Admin\Http\Controllers\AdminTenantRoleController;
use App\Support\Routing\PortalRoutes;
use Illuminate\Support\Facades\Route;

PortalRoutes::admin(function (): void {
    Route::get('/tenants', [AdminTenantController::class, 'index'])->name('tenants.index');
    Route::get('/tenants/create', [AdminTenantController::class, 'create'])->name('tenants.create');
    Route::post('/tenants', [AdminTenantController::class, 'store'])->name('tenants.store');
    Route::get('/tenants/{tenant}', [AdminTenantController::class, 'edit'])->name('tenants.edit');
    Route::post('/tenants/{tenant}/roles', [AdminTenantRoleController::class, 'store'])->name('tenants.roles.store');
    Route::delete('/tenants/{tenant}/roles/{user}', [AdminTenantRoleController::class, 'destroy'])->name('tenants.roles.destroy');
    Route::post('/tenants/{tenant}/commissions', [AdminTenantCommissionController::class, 'store'])->name('tenants.commissions.store');
    Route::post('/tenants/{tenant}/banks', [AdminTenantBankController::class, 'store'])->name('tenants.banks.store');
});
