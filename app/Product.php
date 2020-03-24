<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
  protected $table = 'products';
  protected $fillable = [
    'category_id',
    'product_name',
    'product_code',
    'product_color',
    'description',
    'price',
    'image'
  ];

  public function attributes(){
     return $this->hasMany('App\ProductAttribute','product_id');
  }

  public function category(){
     return $this->belongsTo('App\Category','category_id','id');
  }
}
