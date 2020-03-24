<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductAttribute extends Model
{
  protected $table = 'products_attributes';
  protected $fillable = [
    'product_id',
    'sku',
    'size',
    'price',
    'stock'
  ];
}
