<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProdColor extends Model
{
    protected $table = 'prod_colors';
    protected $fillable = [
        'product_id' , 'color_id'
    ];
    public function color(){
        return $this->belongsTo('App\Color' , 'color_id'  , 'id');
    }



}
