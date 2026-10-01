<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TenantBankAccount extends Model
{
    protected $fillable = [
        'tenant_id', 'verified_by', 'account_number_cipher',
        'account_last4', 'bank_code', 'account_holder', 'status', 'is_primary',
    ];

    protected function casts(): array
    {
        return [
            // Laravel akan otomatis mengenkripsi data saat disimpan dan mendekripsinya saat ditarik
            'account_number_cipher' => 'encrypted',
            'is_primary' => 'boolean',
        ];
    }

    /** @return BelongsTo<Tenant, $this> */
    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }
}
