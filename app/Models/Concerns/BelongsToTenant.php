<?php

namespace App\Models\Concerns;

use App\Support\Tenancy\TenantContext;
use Illuminate\Database\Eloquent\Builder;

trait BelongsToTenant
{
    protected static function bootBelongsToTenant(): void
    {
        // 1. Filter otomatis saat membaca data
        static::addGlobalScope('tenant', function (Builder $builder): void {
            $context = app(TenantContext::class);
            if ($context->has()) {
                $builder->where(
                    $builder->qualifyColumn('tenant_id'),
                    $context->id()
                );
            }
        });

        // 2. Isi otomatis kolom tenant_id saat menyimpan data baru
        static::creating(function ($model): void {
            $context = app(TenantContext::class);
            if ($context->has() && empty($model->tenant_id)) {
                $model->tenant_id = $context->id();
            }
        });
    }
}
