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
//cart  routes
Route::match(['get','post'],'/add_cart','ProductController@addCart');
Route::get('/cart','ProductController@cart');
Route::get('/cart/delete_product/{id}','ProductController@deleteCartProduct');
Route::get('/cart/update_quantity/{id}/{quantitiy}','ProductController@updateCartProduct');
// Apply Coupon
Route::post('/cart/apply_coupon','ProductController@applyCoupon');

// User Routes
Route::match(['get','post'],'/login_register','UsersController@LoginRegister');
Route::match(['get','post'],'/check_email','UsersController@checkEmail');
Route::post('/user_register','UsersController@register');
Route::post('/user_login','UsersController@login');
Route::get('/user_logout','UsersController@logout');

// confirm email
Route::get('/confirm/{code}','UsersController@confirmAccount');

Route::group(['middleware'=>['frontlogin']],function(){

Route::match(['get','post'],'/account','UsersController@account');
// Check User Current Password
	Route::post('/check_user_pwd','UsersController@chkUserPassword');
  // Update User Password
  Route::post('/update_user_pwd','UsersController@updatePassword');
	//checkout page
	Route::match(['get','post'],'/checkout','ProductController@checkout');
  // order review
	Route::match(['get','post'],'/order_review','ProductController@orderReview');
	// order placement
	Route::match(['get','post'],'/place_order','ProductController@placeOrder');
	// thanks page
	Route::get('/thanks','ProductController@thanks');
	// orders page
	Route::get('/orders','ProductController@userOrders');
	//orders details page
  Route::get('/orders/{id}','ProductController@userOrderDetails');
	// paypal page
	Route::get('/paypal','ProductController@paypal');
	// paypal thanks
	Route::get('/paypal/thanks','ProductController@thanksPaypal');

	// paypal page
	Route::get('/paypal/cancel','ProductController@cancelPaypal');

  // make charge using stripe payment

  Route::match(['get','post'],'/charge','ProductController@charge');



});







// Admin Routes

Route::match(['get','post'],'/admin','AdminController@login');
Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

   Route::group(['middleware'=>['adminlogin']],function(){

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
      Route::match(['get','post'],'/admin/edit_attributes/{id}','ProductController@editAttribute');
      Route::get('/admin/delete_attribute/{id}','ProductController@deleteAttribute');

      // add alternate image
        Route::match(['get','post'],'/admin/add_images/{id}','ProductController@addImages');
        Route::get('/admin/delete_alt_image/{id}','ProductController@deleteAltImage');

    // Coupons routes

    Route::match(['get','post'],'/admin/add_coupons','CouponsController@addCoupon');
    Route::get('/admin/view_coupons','CouponsController@viewCoupons');
    Route::match(['get','post'],'/admin/edit_coupon/{id}','CouponsController@editCoupon');
    Route::get('/admin/delete_coupon/{id}','CouponsController@deleteCoupon');

    //banners Routes
     Route::match(['get','post'],'/admin/add_banner','BannersController@addBanner');
     Route::get('/admin/view_banners','BannersController@viewBanners');
     Route::match(['get','post'],'/admin/edit_banner/{id}','BannersController@editBanner');
     Route::get('/admin/delete_banner/{id}','BannersController@deleteBanner');

     //orders routes
		 Route::get('/admin/view_orders','productController@viewOrders');
		 Route::get('/admin/view_order/{id}','productController@viewOrderDetails');
		 Route::post('/admin/update_order_status','ProductController@updateOrderStatus');

		 // view registers users route
		  Route::get('/admin/view_users','UsersController@viewUsers');

});





Route::get('logout','AdminController@logout');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
