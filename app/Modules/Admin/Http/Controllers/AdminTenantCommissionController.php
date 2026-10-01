<?php

namespace App\Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use App\Modules\Admin\Services\CommissionSchemeService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

final class AdminTenantCommissionController extends Controller
{
    use AuthorizesRequests;

    public function __construct(private CommissionSchemeService $service) {}

    public function store(Request $request, Tenant $tenant): RedirectResponse
    {
        $this->authorize('scheduleCommission', $tenant);

        $data = $request->validate([
            'commission_rate' => ['required', 'numeric', 'between:0,100'],
        ]);

        // Ubah persen menjadi desimal (contoh: 15% jadi 0.15)
        $this->service->updateRate($tenant, (float) $data['commission_rate'] / 100);

        return redirect()->route('admin.tenants.edit', $tenant)
            ->with('status', 'Tarif komisi berhasil diperbarui.');
    }
}
