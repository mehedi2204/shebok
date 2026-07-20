<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['name', 'price', 'duration_days', 'features', 'is_active'])]
class Package extends Model
{
    protected $casts = [
        'features' => 'array',
        'is_active' => 'boolean',
    ];
}
