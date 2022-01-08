<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Catering extends Model
{
    protected $fillable = [
        'title_ar',
        'title_en',
        'image',
        'hint_ar',
        'hint_en',
        'desc_ar',
        'desc_en',
        'requirement_ar',
        'requirement_en',
        'persons_no',
        'price',
        'ad_person_price',
        'setup_time',
        'max_time',
        'ad_hour_price',
        'ad_service_price',
        'ad_service_ar',
        'ad_service_en',
    ];

    public function images()
    {
        return $this->hasMany(CateringImage::class);
    }
}
