<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['user_id', 'category_id', 'profession', 'bio', 'experience', 'country_id', 'division_id', 'district_id', 'thana_upazila', 'location', 'price_per_hour', 'rate_type', 'status', 'is_available', 'address', 'nid_path', 'license_path', 'certificate_path', 'experience_path', 'additional_data', 'views', 'pending_update'])]
class ProviderProfile extends Model
{
    protected $casts = [
        'additional_data' => 'array',
        'pending_update' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(ServiceCategory::class, 'category_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function averageRating()
    {
        return $this->reviews()->where('rating', '>', 0)->avg('rating') ?: 0;
    }
}
