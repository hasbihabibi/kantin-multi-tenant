<?php

namespace App\Modules\Admin\Services;

use App\Models\CommissionScheme;
use App\Models\Tenant;
use Illuminate\Support\Facades\DB;

/**
 * Menangani perubahan tarif komisi dengan metode effective-dated.
 * Skema lama ditutup (valid_to = now), skema baru dibuka (valid_from = now).
 */
final class CommissionSchemeService
{
    public function __construct(private AuditLogger $audit) {}

    public function updateRate(Tenant $tenant, float $newRate): void
    {
        DB::transaction(function () use ($tenant, $newRate) {
            $now = now();

            // Cari skema yang saat ini sedang aktif (valid_to masih null)
            $current = CommissionScheme::query()
                ->where('tenant_id', $tenant->id)
                ->whereNull('valid_to')
                ->first();

            // Jika tarifnya sama persis, abaikan saja
            if ($current && (float) $current->commission_rate === $newRate) {
                return;
            }

            // Tutup skema lama
            if ($current) {
                $current->update(['valid_to' => $now]);
            }

            // Buka skema baru
            $newScheme = CommissionScheme::create([
                'tenant_id' => $tenant->id,
                'commission_rate' => $newRate,
                'valid_from' => $now,
                'valid_to' => null,
            ]);

            // Catat di jejak audit CCTV admin
            $this->audit->record('commission_scheme', $newScheme->id, 'updated',
                $current ? ['rate' => $current->commission_rate] : null,
                ['rate' => $newRate],
                $tenant->id, $tenant->canteen_id);
        });
    }
}
