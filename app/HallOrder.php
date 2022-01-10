<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HallOrder extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'street',
        'block',
        'floor',
        'note',
        'start_date',
        'end_date',
        'day_price',
        'days',
        'country_id',
        'city_id',
        'total_price',
        'user_id',
        'hall_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function hall()
    {
        return $this->belongsTo(Hall::class);
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
