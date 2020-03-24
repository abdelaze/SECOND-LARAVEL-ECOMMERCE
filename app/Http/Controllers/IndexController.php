<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Category;

class IndexController extends Controller
{
    public function index(){

       //ASC BY DEFAULT
    //  $products = Product::get();
      //DESC ORDER
    //    $products = Product::orderBy('id','DESC')->get();

      // RANDOM ORDER
        $products = Product::inRandomOrder()->get();
        $categories = Category::with('categories')->where(['parent_id'=>'0'])->get();
      return view('index')->with(compact('products','categories'));
    }
}
