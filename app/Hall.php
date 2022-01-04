<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hall extends Model
{
    protected $table = 'halls';
    protected $fillable = [
        'title_en'  , 'title_ar' , 'description_en','description_ar',
        'price','img','over_price'
    ];
    public function images(){
        return $this->hasMany('App\HallImg' , 'hall_id' , 'id');
    }
}
