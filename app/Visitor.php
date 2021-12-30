<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    protected $fillable = [
        'name', 'email', 'phone', 'region','num_order','sum_order'
    ];


}
