<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BasicCategory extends Model
{
    protected $table = 'basic_categories';
    protected $fillable = [
        'name_ar', 'name_en', 'image_url','type'
    ];

    public function categories(){
        return $this->hasMany('App\Category' , 'basic_category_id' , 'id');
    }


    public function products(){
        return $this->hasMany('App\Product' , 'basic_category_id' , 'id');
    }
}
