<?php

namespace App\Policies;

use App\Models\User;
use App\Support\Tenancy\TenantContext;

class MenuPolicy
{
    public function update(User $user, Menu $menu): bool
    {
        // Boleh diubah HANYA JIKA menu ini milik tenant yang sedang aktif di Context
        return $menu->tenant_id === app(TenantContext::class)->id();
    }

    public function __construct()
    {
        //
    }
}
