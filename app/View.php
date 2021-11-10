<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class View extends Model
{
    protected $table = 'views';

//    protected  $fillable =[ 'product_id'];
protected $guarded=[];
    public function product(){
        return $this->belongsTo('App\Product' , 'product_id' , 'id');
    }
}
