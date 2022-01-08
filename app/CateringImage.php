<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CateringImage extends Model
{
    protected $fillable = [
        'image',
        'catering_id',
    ];
}
