<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductsImage extends Model
{
  protected $table = 'images';
  protected $fillable = [
    'product_id',
    'image',

  ];
}
