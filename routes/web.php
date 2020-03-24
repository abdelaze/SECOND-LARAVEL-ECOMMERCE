<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

/*
Route::get('/', function () {
    return view('comming_soon');
});
*/
// front end routes
Route::get('/','IndexController@index');

// products Routes
Route::get('products/{url}','ProductController@products');
// get product detail
Route::get('product/{id}','ProductController@product');
// get product price
Route::get('/get_product_price','ProductController@getProductPrice');

// Admin Routes

Route::match(['get','post'],'/admin','AdminController@login');
Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
   Route::group(['middleware'=>['auth']],function(){

     Route::get('/admin/dashboard','AdminController@dashboard');
     Route::get('/admin/settings','AdminController@settings');
     Route::get('/admin/check_pwd','AdminController@chkPassword');
     Route::match(['get','post'],'/admin/update_pwd','AdminController@updatePassword');

     //Categpries Routes
     Route::match(['get','post'],'/admin/add_category','CategoryController@addCategory');
     Route::match(['get','post'],'/admin/update_category/{id}','CategoryController@updateCategory');
     Route::match(['get','post'],'/admin/delete_category/{id}','CategoryController@deleteCategory');
     Route::get('/admin/view_category','CategoryController@index');

     //Product Routes
     Route::match(['get','post'],'/admin/add_product','ProductController@addProduct');
     Route::match(['get','post'],'/admin/edit_product/{id}','ProductController@editProduct');
     Route::get('/admin/delete_product_image/{id}','ProductController@deleteProductImage');
     Route::get('/admin/delete_product/{id}','ProductController@deleteProduct');
     Route::get('/admin/view_products','ProductController@viewProducts');

     // Proucts Attributes RouteServiceProvider
      Route::match(['get','post'],'/admin/add_attributes/{id}','ProductController@addAttribute');
      Route::get('/admin/delete_attribute/{id}','ProductController@deleteAttribute');

      // add alternate image
        Route::match(['get','post'],'/admin/add_images/{id}','ProductController@addImages');
          Route::get('/admin/delete_alt_image/{id}','ProductController@deleteAltImage');

});





Route::get('logout','AdminController@logout');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
