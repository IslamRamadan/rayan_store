<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    protected $table = 'products';
    protected $fillable = [
        'title_en'  , 'title_ar' , 'description_en','description_ar',
        'appearance','best_selling','featured','new','price','delivery_period','img','height_img',
        'basic_category_id','category_id','size_guide_id','has_offer','before_price'



    ];
    protected $guarded=[];


    public function category(){
        return $this->belongsTo('App\Category' , 'category_id' , 'id');
    }


    public function basic_category(){
        return $this->belongsTo('App\BasicCategory' , 'basic_category_id' , 'id');
    }
    public function size_guide(){
        return $this->belongsTo('App\SizeGuide' , 'size_guide_id' , 'id');
    }


    public function images(){
        return $this->hasMany('App\ProdImg' , 'product_id' , 'id');
    }

    public function product_hights(){
        return $this->hasMany('App\ProdHeight' , 'product_id'  , 'id');
    }
    public function colors(){
        return $this->hasMany('App\ProdColor' , 'product_id'  , 'id');
    }

    public function product_sizes(){
        return $this->hasMany('App\ProdSize' , 'product_id'  , 'id');
    }
    public function getPrice($price){
        $currencies = Currency::all();
        foreach ($currencies as $currency){
            if ($this->country()->currency_id == $currency->id){
                $price= $price*$currency->rate;
            }
        }
        return $price;
    }
}
