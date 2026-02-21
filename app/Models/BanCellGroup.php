<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BanCellGroup extends Model
{
    use HasUuids;

    const UPDATED_AT = null;

    protected $fillable = [
        'hole_number',
        'comment',
    ];

    public function cells(): HasMany
    {
        return $this->hasMany(BanCell::class, 'group_id');
    }
}
