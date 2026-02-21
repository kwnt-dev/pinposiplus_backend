<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BanCell extends Model
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
        return $this->belongsTo(BanCellGroup::class, 'group_id');
    }
}
