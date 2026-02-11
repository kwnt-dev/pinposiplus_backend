<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class DailySchedule extends Model
{
    use HasUuids;

    protected $fillable = [
        'date',
        'event_name',
        'group_count',
        'notes',
    ];
}