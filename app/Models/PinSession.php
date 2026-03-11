<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PinSession extends Model
{
    use HasFactory, HasUuids;

    // ステータス遷移: draft → published → confirmed → sent
    protected $fillable = [
        'course',
        'status',
        'target_date',
        'event_name',
        'groups_count',
        'is_rainy',
        'created_by',
        'submitted_by',
        'submitted_by_name',
        'submitted_at',
        'approved_by',
        'approved_at',
        'published_at',
        'pdf_url',
    ];

    protected $casts = [
        'target_date' => 'date:Y-m-d',
        'submitted_at' => 'datetime',
        'approved_at' => 'datetime',
        'published_at' => 'datetime',
        'groups_count' => 'integer',
        'is_rainy' => 'boolean',
    ];

    // セッション作成者
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // 確認提出者
    public function submitter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'submitted_by');
    }

    // セッションに紐づくピン一覧
    public function pins(): HasMany
    {
        return $this->hasMany(Pin::class, 'session_id');
    }
}
