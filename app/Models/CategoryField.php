<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['category_id', 'label', 'type', 'is_required', 'options', 'order'])]
class CategoryField extends Model
{
    protected $casts = [
        'is_required' => 'boolean',
        'options' => 'array',
    ];

    public function category()
    {
        return $this->belongsTo(ServiceCategory::class);
    }
}
