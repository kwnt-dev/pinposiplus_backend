<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pin extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'hole_number',
        'x',
        'y',
        'session_id',
        'created_by',
    ];

    // 作成者
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // 所属セッション
    public function session(): BelongsTo
    {
        return $this->belongsTo(PinSession::class, 'session_id');
    }
}
