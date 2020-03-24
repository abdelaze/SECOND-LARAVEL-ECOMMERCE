<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
  protected $table = 'categories';
  protected $fillable = [
    'category_name',
    'description',
    'url',
    'parent_id',
    'status'
  ];
  public function products(){
    return $this->hasMany('App\Product');
  }

  public function categories(){
      return $this->hasMany('App\Category','parent_id');
  }
}
