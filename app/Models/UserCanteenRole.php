<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserCanteenRole extends Model
{
    protected $fillable = ['user_id', 'canteen_id', 'role'];

    /** @return BelongsTo<Canteen, $this> */
    public function canteen(): BelongsTo
    {
        return $this->belongsTo(Canteen::class);
    }
}
