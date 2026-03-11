<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PinHistory extends Model
{
    use HasUuids;

    const UPDATED_AT = null;

    protected $table = 'pin_history';

    protected $fillable = [
        'date',
        'hole_number',
        'x',
        'y',
        'submitted_by',
    ];

    // 提出者
    public function submitter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'submitted_by');
    }
}
