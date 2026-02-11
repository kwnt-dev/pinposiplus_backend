<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class BanCell extends Model
{
    use HasUuids;

    const UPDATED_AT = null;

    protected $fillable = [
        'hole_number',
        'x',
        'y',
    ];
}