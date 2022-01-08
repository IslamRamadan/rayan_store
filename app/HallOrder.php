<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HallOrder extends Model
{
    protected $fillable = [
        'start_date',
        'end_date',
        'day_price',
        'days',
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
}
