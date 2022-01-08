<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CateringOrder extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'street',
        'block',
        'floor',
        'address',
        'note',
        'request_female',
        'price',
        'persons_no',
        'ad_hours',
        'ad_hours_price',
        'ad_service',
        'ad_service_price',
        'total_price',
        'user_id',
        'catering_id',
        'country_id',
        'city_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function catering()
    {
        return $this->belongsTo(Catering::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
