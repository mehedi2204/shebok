<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Support\Str;

#[Fillable(['name', 'slug', 'tagline', 'icon', 'require_certificate', 'require_experience'])]
class ServiceCategory extends Model
{
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($category) {
            $category->slug = Str::slug($category->name);
        });
    }

    public function providers()
    {
        return $this->hasMany(ProviderProfile::class, 'category_id');
    }

    public function fields()
    {
        return $this->hasMany(CategoryField::class, 'category_id');
    }
}
