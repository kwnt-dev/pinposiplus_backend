<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

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
}
