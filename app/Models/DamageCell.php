<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DamageCell extends Model
{
    use HasUuids;

    const UPDATED_AT = null;

    protected $fillable = [
        'group_id',
        'hole_number',
        'x',
        'y',
    ];

    public function group(): BelongsTo
    {
        return $this->belongsTo(DamageCellGroup::class, 'group_id');
    }
}
