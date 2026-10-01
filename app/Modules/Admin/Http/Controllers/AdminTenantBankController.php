<?php

namespace App\Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use App\Models\TenantBankAccount;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

final class AdminTenantBankController extends Controller
{
    use AuthorizesRequests;

    public function store(Request $request, Tenant $tenant): RedirectResponse
    {
        $this->authorize('manageBank', $tenant);

        $data = $request->validate([
            'bank_code' => ['required', 'string', 'max:20'],
            'account_number' => ['required', 'string', 'min:4', 'max:50'],
            'account_holder' => ['required', 'string', 'max:120'],
        ]);

        TenantBankAccount::create([
            'tenant_id' => $tenant->id,
            'bank_code' => strtoupper($data['bank_code']),
            'account_number_cipher' => $data['account_number'], // Otomatis disandikan oleh Laravel
            'account_last4' => substr($data['account_number'], -4), // Ambil 4 digit terakhir
            'account_holder' => strtoupper($data['account_holder']),
            'status' => 'unverified',
        ]);

        return redirect()->route('admin.tenants.edit', $tenant)->with('status', 'Rekening bank ditambahkan.');
    }
}
