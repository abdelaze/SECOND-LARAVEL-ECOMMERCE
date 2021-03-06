<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Input;
use Cartalyst\Stripe\Laravel\Facades\Stripe;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Auth;
use Session;
use Image;
use App\Category;
use App\Product;
use App\ProductAttribute;
use App\ProductsImage;
use App\Coupon;
use DB;
use App\Country;
use App\User;
use App\DeliveryAddress;
use App\Order;
use App\OrdersProduct;
use Mail;
use DataTables;


class ProductController extends Controller
{
    public function addProduct(Request $request) {


           if($request->isMethod('post')){

             $data = $request->all();
//echo "<pre>"; print_r($data); die;

              $product = new Product;
               $product->category_id = $data['category_id'];
               $product->product_name = $data['product_name'];
               $product->product_code = $data['product_code'];
                $product->product_color = $data['product_color'];
                $product->image ='';
                if(!empty($data['description'])){
                     $product->description = $data['description'];
                 }else{
                     $product->description = '';
                }

                if(!empty($data['care'])){
                     $product->care = $data['care'];
                 }else{
                     $product->care = '';
                }

                			$product->price = $data['price'];

                      if($request->hasFile('image')){
                    	$image_tmp =  $request->file('image');

                        if ($image_tmp->isValid()) {
                            // Upload Images after Resize
                            $extension = $image_tmp->getClientOriginalExtension();
        	                $fileName = rand(111,99999).'.'.$extension;
                            $large_image_path = 'images/backend_images/product/large'.'/'.$fileName;
                            $medium_image_path = 'images/backend_images/product/medium'.'/'.$fileName;
                            $small_image_path = 'images/backend_images/product/small'.'/'.$fileName;
                          // Save Images In the specific path in sasve
         	                Image::make($image_tmp)->save($large_image_path);
         				        	Image::make($image_tmp)->resize(600, 600)->save($medium_image_path);
             		      		Image::make($image_tmp)->resize(300, 300)->save($small_image_path);

             	       			$product->image = $fileName;

                        }
                    }
                    if(empty( $request->input('status'))) {
                         $data['status'] = 0;
                    }else {
                        $data['status'] = 1;
                    }
                    $product->status = $data['status'];

                    $product->save();
		            	return redirect()->back()->with('flash_success_message', 'Product has been added successfully');
         }


               $categories = Category::where(['parent_id' => 0])->get();
               $categories_drop_down = "<option value='' selected disabled>Select</option>";
               foreach($categories as $cat){
                   $categories_drop_down .= "<option value='".$cat->id."'>".$cat->category_name."</option>";
                   $sub_categories = Category::where(['parent_id' => $cat->id])->get();
                   foreach($sub_categories as $sub_cat){
                       $categories_drop_down .= "<option value='".$sub_cat->id."'>&nbsp;&nbsp;--&nbsp;".$sub_cat->category_name."</option>";
                 }
              }



            return view('admin.products.add_product')->with(compact('categories_drop_down'));

    } // End Add Products

    public function viewProducts(){
          $products = Product::get();
          return view('admin.products.view_products')->with(compact('products'));
    } // End View Function

    public function editProduct(Request $request , $id=null){

      if($request->isMethod('post')){


               $data = $request->all();

               if($request->hasFile('image')){
                     $image_tmp = $request->file('image');
                     if ($image_tmp->isValid()) {
                  // Upload Images after Resize
                          $extension = $image_tmp->getClientOriginalExtension();
                          $fileName = rand(111,99999).'.'.$extension;
                          $large_image_path = 'images/backend_images/product/large'.'/'.$fileName;
                          $medium_image_path = 'images/backend_images/product/medium'.'/'.$fileName;
                          $small_image_path = 'images/backend_images/product/small'.'/'.$fileName;

                          Image::make($image_tmp)->save($large_image_path);
                          Image::make($image_tmp)->resize(600, 600)->save($medium_image_path);
                          Image::make($image_tmp)->resize(300, 300)->save($small_image_path);

                  }
            }else if(!empty($data['current_image'])){
                         $fileName = $data['current_image'];
            }else{
                       $fileName = '';
            }

            if(empty($data['description'])){
                      $data['description'] = '';
            }
            if(empty($data['care'])){
                      $data['care'] = '';
            }
            if(empty( $request->input('status'))) {
                 $data['status'] = 0;
            }else {
                $data['status'] = 1;
            }

                Product::where(['id'=>$id])->update(['category_id'=>$data['category_id'],'product_name'=>$data['product_name'],
                'product_code'=>$data['product_code'],'product_color'=>$data['product_color'],'description'=>$data['description'],'care'=>$data['care'],'price'=>$data['price'],'image'=>$fileName,'status'=>$data['status']]);

                 return redirect()->back()->with('flash_success_message', 'Product has been edited successfully');
       }

// Get Product Details start //
     $productDetails = Product::where(['id'=>$id])->first();
// Get Product Details End //

// Categories drop down start //
      $categories = Category::where(['parent_id' => 0])->get();

      $categories_drop_down = "<option value='' disabled>Select</option>";
      foreach($categories as $cat){
                if($cat->id==$productDetails->category_id){
                             $selected = "selected";
                }else{
                      $selected = "";
               }
     $categories_drop_down .="<option value='".$cat->id."' ".$selected.">".$cat->category_name."</option>";
     $sub_categories = Category::where(['parent_id' => $cat->id])->get();
     foreach($sub_categories as $sub_cat){
     if($sub_cat->id==$productDetails->category_id){
             $selected = "selected";
     }else{
      $selected = "";
     }
    $categories_drop_down .="<option value='".$sub_cat->id."' ".$selected.">&nbsp;&nbsp;--&nbsp;".$sub_cat->category_name."</option>";
  }
}
// Categories drop down end //

    return view('admin.products.edit_product')->with(compact('productDetails','categories_drop_down'));
} // End Edit Function


public function deleteProductImage($id=null) {

  // Get Product Image
  $productImage = Product::where('id',$id)->first();

  // Get Product Image Paths
  $large_image_path = 'images/backend_images/product/large/';
  $medium_image_path = 'images/backend_images/product/medium/';
  $small_image_path = 'images/backend_images/product/small/';

  // Delete Large Image if not exists in Folder
      if(file_exists($large_image_path.$productImage->image)){
          unlink($large_image_path.$productImage->image);
      }

      // Delete Medium Image if not exists in Folder
      if(file_exists($medium_image_path.$productImage->image)){
          unlink($medium_image_path.$productImage->image);
      }

      // Delete Small Image if not exists in Folder
      if(file_exists($small_image_path.$productImage->image)){
          unlink($small_image_path.$productImage->image);
      }


    Product::where(['id'=>$id])->update(['image'=>""]);
    return redirect()->back()->with('flash_success_message','Product Image has been delted successfully');
}// end deleteProductImage function

public function deleteProduct($id=null){
   Product::where(['id'=>$id])->delete();
     return redirect()->back()->with('flash_success_message','Product has been delted successfully');
}  // end deleteProduct function

// add attribute function

public function addAttribute(Request $request , $id=null) {

     $productDetails = Product::with('attributes')->where(['id'=>$id])->first();
     if($request->isMethod('post')){
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;

            foreach($data['sku'] as $key => $val){
                if(!empty($val)){


                  $attrCountSKU = ProductAttribute::where(['sku'=>$val])->count();
                  if($attrCountSKU>0){
                      return redirect('admin/add_attributes/'.$id)->with('flash_message_error', 'SKU already exists. Please add another SKU.');
                  }
                  $attrCountSizes = ProductAttribute::where(['product_id'=>$id,'size'=>$data['size'][$key]])->count();
                  if($attrCountSizes>0){
                      return redirect('admin/add-attributes/'.$id)->with('flash_message_error', 'Attribute already exists. Please add another Attribute.');
                  }

                    $attr = new ProductAttribute;
                    $attr->product_id = $id;
                    $attr->sku = $val;
                    $attr->size = $data['size'][$key];
                    $attr->price = $data['price'][$key];
                    $attr->stock = $data['stock'][$key];
                    $attr->save();
                }
            }
            return redirect('admin/add_attributes/'.$id)->with('flash_success_message', 'Product Attributes has been added successfully');

        }
     return view('admin.products.add_attributes')->with(compact('productDetails'));
}


// edit attribute function
public function editAttribute(Request $request , $id=null){

  if($request->isMethod('post')){
           $data = $request->all();
           /*echo "<pre>"; print_r($data); die;*/
           foreach($data['idAttr'] as $key=> $attr){
               if(!empty($attr)){
                   ProductAttribute::where(['id' => $data['idAttr'][$key]])->update(['price' => $data['price'][$key], 'stock' => $data['stock'][$key]]);
               }
           }
           return redirect('admin/add_attributes/'.$id)->with('flash_success_message', 'Product Attributes has been updated successfully');
       }
}

// add product alternate images
public function addImages(Request $request, $id=null){
        $productDetails = Product::where(['id' => $id])->first();



        if($request->isMethod('post')){
            $data = $request->all();
          //  $data = json_decode(json_encode($data));
          //  echo "<pre>";  print_r($data); die;
            if ($request->hasFile('image')) {
                $files = $request->file('image');

                foreach($files as $file){
                    // Upload Images after Resize
                    $image = new ProductsImage;
                    $extension = $file->getClientOriginalExtension();
                    $fileName = rand(111,99999).'.'.$extension;
                    $large_image_path = 'images/backend_images/product/large'.'/'.$fileName;
                    $medium_image_path = 'images/backend_images/product/medium'.'/'.$fileName;
                    $small_image_path = 'images/backend_images/product/small'.'/'.$fileName;
                    Image::make($file)->save($large_image_path);
                    Image::make($file)->resize(600, 600)->save($medium_image_path);
                    Image::make($file)->resize(300, 300)->save($small_image_path);
                    $image->image = $fileName;
                    $image->product_id = $data['product_id'];
                    $image->save();
                }
            }

            return redirect('admin/add_images/'.$id)->with('flash_success_message', 'Product Images has been added successfully');

        }

         $images = ProductsImage::where(['product_id'=>$id])->get();
        return view('admin.products.add_images')->with(compact('productDetails','images'));
    }

// delete alt image
public function deleteAltImage($id = null) {
     $image = ProductsImage::where(['id'=>$id])->first();
     // Get Product Image Paths
     $large_image_path = 'images/backend_images/product/large/';
     $medium_image_path = 'images/backend_images/product/medium/';
     $small_image_path = 'images/backend_images/product/small/';

     // Delete Large Image if not exists in Folder
         if(file_exists($large_image_path.$image->image)){
             unlink($large_image_path.$image->image);
         }

         // Delete Medium Image if not exists in Folder
         if(file_exists($medium_image_path.$image->image)){
             unlink($medium_image_path.$image->image);
         }

         // Delete Small Image if not exists in Folder
         if(file_exists($small_image_path.$image->image)){
             unlink($small_image_path.$image->image);
         }


       ProductsImage::where(['id'=>$id])->delete();
       return redirect()->back()->with('flash_success_message','Product Image has been delted successfully');
   }// end deleteProductImage function

// delete attribute
public function deleteAttribute($id=null){
  ProductAttribute::where(['id'=>$id])->delete();
  return redirect()->back()->with('flash_success_message','Attribute Has Been Deleted Successfully!');
}


// product function
public function products($url=null) {

     $countCategory = Category::where(['url'=>$url,'status'=>1])->count();
     if($countCategory == 0) {
        abort(404);
     }
     $categoryDetails = Category::where(['url'=>$url])->first(); // first because it is one item
     $categories = Category::with('categories')->where(['parent_id'=>'0'])->get();
     if($categoryDetails->parent_id == 0) {
        $subcats = Category::where(['parent_id'=>$categoryDetails->id])->get();
        $subcatsid = [];

        foreach ($subcats as $subcat) {
          $subcatsid[]= $subcat->id;
         }
          $products = Product::whereIn('category_id',$subcatsid)->where('status',1)->get();
      //  echo $subcatsid; die;
    }else {
     $products = Product::where(['category_id'=>$categoryDetails->id])->where('status',1)->get();
   }
    return view('products.listing')->with(compact('products','categoryDetails','categories'));
} // end products

// product detail

public function product($id=null) {

        $productsCount = Product::where(['id'=>$id,'status'=>1])->count();
        if($productsCount == 0) {
          abort(404);
        }

     $productDetails = Product::with('attributes')->where(['id'=>$id])->first();

     $categories = Category::with('categories')->where(['parent_id'=>'0'])->get();
     $productaltimages = ProductsImage::where(['product_id'=>$id])->get();
     $count = ProductsImage::where(['product_id'=>$id])->count();
    // echo $count; die;
    $totalstock = ProductAttribute::where(['product_id'=>$id])->sum('stock');
    //echo $totalstock; die;
    $relatedProducts = Product::where('id','!=',$id)->where(['category_id'=>$productDetails->category_id])->get();

     return view('products.detail')->with(compact('productDetails','categories','productaltimages','count','totalstock','relatedProducts'));

}

// get product pricr and we will write code in main.js
public function getProductPrice(Request $request) {

    $data = $request->all();

    $proArr = explode("-",$data['idsize']);
    $proAttr = ProductAttribute::where(['product_id'=>$proArr[0],'size'=>$proArr[1]])->first();
    echo $proAttr->price; // this result i will use it in ajax and put it in price  echo mean response it is important
    echo "#";
    echo $proAttr->stock;
}

// Add Items To Cart
public function addCart(Request $request){

        Session::forget('CouponAmount');
        Session::forget('CouponCode');
        $data = $request->all();
       /*echo "<pre>"; print_r($data); die;*/
       // Check Product Stock is available or not
       $product_size = explode("-",$data['size']);
       $getProductStock = ProductAttribute::where(['product_id'=>$data['product_id'],'size'=>$product_size[1]])->first();

       if($getProductStock->stock<$data['quantity']){
           return redirect()->back()->with('flash_message_error','Required Quantity is not available!');
       }
       if(empty(Auth::user()->email)){
           $data['user_email'] = '';
       }else{
           $data['user_email'] = Auth::user()->email;
       }
       $session_id = Session::get('session_id');
         if(!isset($session_id)){
             $session_id = Str::random(40);
             Session::put('session_id',$session_id);
         }




       $sizeIDArr = explode('-',$data['size']);
       $product_size = $sizeIDArr[1];
       $getSKU = ProductAttribute::select('sku')->where(['product_id' => $data['product_id'], 'size' => $product_size])->first();

       $countProducts = DB::table('cart')->where(['product_id' => $data['product_id'],'product_color' => $data['product_color'],'size' => $product_size,'session_id' => $session_id])->count();
    //   echo $countProducts; die;
         if($countProducts>0){
             return redirect()->back()->with('flash_message_error','Product already exist in Cart!');
         }

        DB::table('cart')->insert(['product_id' => $data['product_id'],'product_name' => $data['product_name'],
        'product_code' => $getSKU['sku'],'product_color' => $data['product_color'],
        'price' => $data['price'],'size' => $product_size,'quantity' => $data['quantity'],
        'user_email' => $data['user_email'],'session_id' =>$session_id]);

         return redirect('cart')->with('flash_success_message','Product has been added in Cart!');

}

public function cart() {

  if(Auth::check()){
       $user_email = Auth::user()->email;
       $userCart = DB::table('cart')->where(['user_email' => $user_email])->get();
   } else {
      $session_id = Session::get('session_id');
      $userCart = DB::table('cart')->where(['session_id' => $session_id])->get();
  }

      foreach($userCart as $key => $product){
               $productDetails = Product::where('id',$product->product_id)->first();
               $userCart[$key]->image = $productDetails->image;
           }

         /*echo "<pre>"; print_r($userCart); die;*/
         return view('products.cart')->with(compact('userCart'));
}

public function cart2(Request $request) {

  if($request->ajax())
     {
          if(Auth::check()){
               $user_email = Auth::user()->email;
               $userCart = DB::table('cart')->where(['user_email' => $user_email])->get();
           } else {
              $session_id = Session::get('session_id');
              $userCart = DB::table('cart')->where(['session_id' => $session_id])->get();
          }

              foreach($userCart as $key => $product){
                       $productDetails = Product::where('id',$product->product_id)->first();
                       $userCart[$key]->image = $productDetails->image;
                   }


                 /*echo "<pre>"; print_r($userCart); die;*/
                 return DataTables::of($userCart)
                   ->addColumn('action', function($userCart){

                       $button = '<button type="button" name="delete" id="'.$userCart->id.'" class="cart_quantity_delete btn btn-danger btn-sm"><i class="fa fa-times"></i></button>';


                       return $button;

                   })
                   ->rawColumns(['action'])
                   ->make(true);
       }



             return view('products.cart2');

}

public function deleteCartProduct($id = null ) {
  Session::forget('CouponAmount');
  Session::forget('CouponCode');
   DB::table('cart')->where(['id'=>$id])->delete();
   return redirect('cart')->with('flash_success_message','Product has been deleted Successfully!');
}

public function updateCartProduct($id = null ,$quantity= null) {

  Session::forget('CouponAmount');
  Session::forget('CouponCode');
    $getProductSKU = DB::table('cart')->select('product_code','quantity')->where('id',$id)->first();
       $getProductStock = ProductAttribute::where('sku',$getProductSKU->product_code)->first();
       $updated_quantity = $getProductSKU->quantity+$quantity;
       if($getProductStock->stock >= $updated_quantity){
           DB::table('cart')->where('id',$id)->increment('quantity',$quantity);
            return redirect('cart')->with('flash_success_message','Quantity has been updated Successfully!');
       }else{
           return redirect('cart')->with('flash_message_error','Required Product Quantity is not available!');
       }

}
// public function updateCartProduct(Request $request) {
//   $data = $request->all();
//   //echo $data['cartID']; die;
//     Session::forget('CouponAmount');
//     Session::forget('CouponCode');
//       $getProductSKU = DB::table('cart')->select('product_code','quantity')->where('id',$data['cartID'])->first();
//          $getProductStock = ProductAttribute::where('sku',$getProductSKU->product_code)->first();
//          $updated_quantity = $getProductSKU->quantity+ $data['quantity'];
//          if($getProductStock->stock >= $updated_quantity){
//              DB::table('cart')->where('id',$data['cartID'])->increment('quantity',$data['quantity']);
//             // return redirect('cart')->with('flash_success_message','Quantity has been updated Successfully!');
//
//                 $cartdata =  DB::table('cart')->where('id',$data['cartID'])->first();
//                 return response()->json(['quantity' => $cartdata->quantity]);
//          }else{
//
//              //return redirect('cart')->with('flash_message_error','Required Product Quantity is not available!');
//              return response()->json(['error' => 'Required Product Quantity is not available!']);
//          }
//
// }


// Apply Coupon
public function applyCoupon(Request $request) {

   Session::forget('CouponAmount');
   Session::forget('CouponCode');

   $data = $request->all();
   $count = Coupon::where('coupon_code',$data['coupon_code'])->count();
   if($count == 0) {
      return redirect()->back()->with('flash_message_error','Coupon Code  is invalid!');
   }else {

     // with perform other checks like Active/Inactive, Expiry date..

         // Get Coupon Details
         $couponDetails = Coupon::where('coupon_code',$data['coupon_code'])->first();

         // If coupon is Inactive
         if($couponDetails->status==0){
             return redirect()->back()->with('flash_message_error','This coupon is not active!');
         }

         // If coupon is Expired
         $expiry_date = $couponDetails->expiry_date;
         $current_date = date('Y-m-d');
         if($expiry_date < $current_date){
             return redirect()->back()->with('flash_message_error','This coupon is expired!');
         }

           $session_id = Session::get('session_id');
           if(Auth::check()){
                $user_email = Auth::user()->email;
                $userCart = DB::table('cart')->where(['user_email' => $user_email])->get();
            } else {
               $session_id = Session::get('session_id');
               $userCart = DB::table('cart')->where(['session_id' => $session_id])->get();
           }


            $total_amount = 0;
            foreach($userCart as $item){
               $total_amount = $total_amount + ($item->price * $item->quantity);
            }

            // Check if amount type is Fixed or Percentage
               if($couponDetails->amount_type=="fixed"){
                   $couponAmount = $couponDetails->amount;
               }else{
                   $couponAmount = $total_amount * ($couponDetails->amount/100);
               }

               // Add Coupon Code & Amount in Session
               Session::put('CouponAmount',$couponAmount);
               Session::put('CouponCode',$data['coupon_code']);

               return redirect()->back()->with('flash_success_message','Coupon code successfully
                   applied. You are availing discount!');


   }  // end else
} //

//checkout
public function checkout(Request $request) {
     $user_id = Auth::user()->id;
     $user_email = Auth::user()->email;
     $userDetails = User::find($user_id);
     $countries = Country::get();

     //Check if Shipping Address exists
     $shippingCount = DeliveryAddress::where('user_id',$user_id)->count();
     $shippingDetails = array();
     if($shippingCount>0){
         $shippingDetails = DeliveryAddress::where('user_id',$user_id)->first();
     }

     // Update cart table with user email
     $session_id = Session::get('session_id');
     DB::table('cart')->where(['session_id'=>$session_id])->update(['user_email'=>$user_email]);
     if($request->isMethod('post')){
         $data = $request->all();
         /*echo "<pre>"; print_r($data); die;*/
         // Return to Checkout page if any of the field is empty
         if(empty($data['billing_name']) || empty($data['billing_address']) || empty($data['billing_city']) || empty($data['billing_state']) || empty($data['billing_country']) || empty($data['billing_pincode']) || empty($data['billing_mobile']) || empty($data['shipping_name']) || empty($data['shipping_address']) || empty($data['shipping_city']) || empty($data['shipping_state']) || empty($data['shipping_country']) || empty($data['shipping_pincode']) || empty($data['shipping_mobile'])){
                 return redirect()->back()->with('flash_message_error','Please fill all fields to Checkout!');
         }

         // Update User details
         User::where('id',$user_id)->update(['name'=>$data['billing_name'],'address'=>$data['billing_address'],'city'=>$data['billing_city'],'state'=>$data['billing_state'],'pincode'=>$data['billing_pincode'],'country'=>$data['billing_country'],'mobile'=>$data['billing_mobile']]);

         if($shippingCount>0){
             // Update Shipping Address
             DeliveryAddress::where('user_id',$user_id)->update(['name'=>$data['shipping_name'],'address'=>$data['shipping_address'],'city'=>$data['shipping_city'],'state'=>$data['shipping_state'],'pincode'=>$data['shipping_pincode'],'country'=>$data['shipping_country'],'mobile'=>$data['shipping_mobile']]);
         }else{
             // Add New Shipping Address
             $shipping = new DeliveryAddress;
             $shipping->user_id = $user_id;
             $shipping->user_email = $user_email;
             $shipping->name = $data['shipping_name'];
             $shipping->address = $data['shipping_address'];
             $shipping->city = $data['shipping_city'];
             $shipping->state = $data['shipping_state'];
             $shipping->pincode = $data['shipping_pincode'];
             $shipping->country = $data['shipping_country'];
             $shipping->mobile = $data['shipping_mobile'];
             $shipping->save();
         }

         return redirect()->action('ProductController@orderReview');
     }

     return view('products.checkout')->with(compact('userDetails','countries','shippingDetails'));
}

// order review
public function orderReview(Request $request) {
        $user_id = Auth::user()->id;
        $user_email = Auth::user()->email;
        $userDetails = User::where('id',$user_id)->first();
        $shippingDetails = DeliveryAddress::where('user_id',$user_id)->first();
        $shippingDetails = json_decode(json_encode($shippingDetails));
        $userCart = DB::table('cart')->where(['user_email' => $user_email])->get();
        foreach($userCart as $key => $product){
            $productDetails = Product::where('id',$product->product_id)->first();
            $userCart[$key]->image = $productDetails->image;
        }
        /*echo "<pre>"; print_r($userCart); die;*/
        return view('products.order_review')->with(compact('userDetails','shippingDetails','userCart'));

}

public function placeOrder(Request $request) {
  if($request->isMethod('post')){
       $data = $request->all();
       $user_id = Auth::user()->id;
       $user_email = Auth::user()->email;

       // Get Shipping Address of User
       $shippingDetails = DeliveryAddress::where(['user_email' => $user_email])->first();

       /*echo "<pre>"; print_r($data); die;*/

       if(empty(Session::get('CouponCode'))){
              $coupon_code = '';
           } else{
              $coupon_code = Session::get('CouponCode');
           }

           if(empty(Session::get('CouponAmount'))){
              $coupon_amount = 0;
           }else{
              $coupon_amount = Session::get('CouponAmount');
           }

       $order = new Order;
       $order->user_id = $user_id;
       $order->user_email = $user_email;
       $order->name = $shippingDetails->name;
       $order->address = $shippingDetails->address;
       $order->city = $shippingDetails->city;
       $order->state = $shippingDetails->state;
       $order->pincode = $shippingDetails->pincode;
       $order->country = $shippingDetails->country;
       $order->mobile = $shippingDetails->mobile;
       $order->coupon_code = $coupon_code;
       $order->coupon_amount = $coupon_amount;
       $order->order_status = "New";
       $order->payment_method = $data['payment_method'];
       $order->grand_total = $data['grand_total'];
       $order->save();

       $order_id = DB::getPdo()->lastInsertId();

            $cartProducts = DB::table('cart')->where(['user_email'=>$user_email])->get();
            foreach($cartProducts as $pro){
                $cartPro = new OrdersProduct;
                $cartPro->order_id = $order_id;
                $cartPro->user_id = $user_id;
                $cartPro->product_id = $pro->product_id;
                $cartPro->product_code = $pro->product_code;
                $cartPro->product_name = $pro->product_name;
                $cartPro->product_color = $pro->product_color;
                $cartPro->product_size = $pro->size;
                $cartPro->product_price = $pro->price;
                $cartPro->product_qty = $pro->quantity;
                $cartPro->save();
            }

           Session::put('order_id',$order_id);
           Session::put('grand_total',$data['grand_total']);
           if($data['payment_method'] == "COD") {

             $productDetails = Order::with('orders')->where('id',$order_id)->first();
            // $productDetails = json_decode(json_encode($productDetails),true);
             /*echo "<pre>"; print_r($productDetails);*/ /*die;*/

             $userDetails = User::where('id',$user_id)->first();
            // $userDetails = json_decode(json_encode($userDetails),true);
             /*echo "<pre>"; print_r($userDetails); die; */
             /* Code for Order Email Start */
             $email = $user_email;
             $messageData = [
                 'email' => $email,
                 'name' => $shippingDetails->name,
                 'order_id' => $order_id,
                 'productDetails' => $productDetails,
                 'userDetails' => $userDetails
             ];
             Mail::send('emails.order',$messageData,function($message) use($email){
                 $message->to($email)->subject('Order Placed - E-com Website');
             });
             /* Code for Order Email Ends */

               return redirect('/thanks');
           }else {
             return redirect('/paypal');
           }


    }
} //end method

// thanks func
public function thanks() {
    $user_email = Auth::user()->email;
    DB::table('cart')->where('user_email',$user_email)->delete();
    return view('orders.thanks');
}

// paypal func
public function paypal() {
      $user_email = Auth::user()->email;
      DB::table('cart')->where('user_email',$user_email)->delete();
      return view('orders.paypal');
}

//order
public function userOrders() {
  $user_id = Auth::user()->id;
     $orders = Order::with('orders')->where('user_id',$user_id)->orderBy('id','DESC')->get();
     /*$orders = json_decode(json_encode($orders));
     echo "<pre>"; print_r($orders); die;*/
     return view('orders.user_orders')->with(compact('orders'));
}

// order details
public function userOrderDetails($order_id){
        $user_id = Auth::user()->id;
        $orderDetails = Order::with('orders')->where('id',$order_id)->first();
        //$orderDetails = json_decode(json_encode($orderDetails));
        /*echo "<pre>"; print_r($orderDetails); die;*/
        return view('orders.user_order_details')->with(compact('orderDetails'));
}

// order invoice


public function thanksPaypal(){
   return view('orders.thanks_paypal');
}

public function cancelPaypal(){
   return view('orders.cancel_paypal');
}


// chaRGE

public function charge(Request $request) {
  // echo "yes";

   $charge = Stripe::charges()->create([

        'currency' =>'USD',
         'source' => $request->stripeToken,
         'amount' => $request->amount,
         'description' => 'test from laravel new app',
   ]);

    $chargeId = $charge['id'];
     if($chargeId) {
         return redirect()->action('ProductController@thanks');
     }else {
        echo "error"; die;
     }

}

// orders view in admin

public function viewOrders(){
       $orders = Order::with('orders')->orderBy('id','Desc')->get();
    //   $orders = json_decode(json_encode($orders));
       /*echo "<pre>"; print_r($orders); die;*/
       return view('admin.orders.view_orders')->with(compact('orders'));
}

// order details on admin panel
public function viewOrderDetails($order_id){
        $orderDetails = Order::with('orders')->where('id',$order_id)->first();
        //$orderDetails = json_decode(json_encode($orderDetails));
        /*echo "<pre>"; print_r($orderDetails); die;*/
        $user_id = $orderDetails->user_id;
        $userDetails = User::where('id',$user_id)->first();
        /*$userDetails = json_decode(json_encode($userDetails));
        echo "<pre>"; print_r($userDetails);*/
        return view('admin.orders.order_details')->with(compact('orderDetails','userDetails'));
}

//order invoice

public function viewOrderInvoice($order_id){

        $orderDetails = Order::with('orders')->where('id',$order_id)->first();
      //  $orderDetails = json_decode(json_encode($orderDetails));
        /*echo "<pre>"; print_r($orderDetails); die;*/
        $user_id = $orderDetails->user_id;
        $userDetails = User::where('id',$user_id)->first();
        /*$userDetails = json_decode(json_encode($userDetails));
        echo "<pre>"; print_r($userDetails);*/
        return view('admin.orders.order_invoice')->with(compact('orderDetails','userDetails'));
}




//update order status

public function updateOrderStatus(Request $request) {
   if($request->isMethod('post')) {
          $data = $request->all();
          Order::where('id',$data['order_id'])->update(['order_status'=>$data['order_status']]);
          return redirect()->back()->with('flash_success_message','order status has been updated successfully! ');
   }
}

// Search products by code or name
public function searchProducts(Request $request){
       if($request->isMethod('post')){
           $data = $request->all();
           /*echo "<pre>"; print_r($data); die;*/

           $categories = Category::with('categories')->where(['parent_id' => 0])->get();

           $search_product = $data['product'];

           $products = Product::where('product_name','like','%'.$search_product.'%')->orwhere('product_code',$search_product)->where('status',1)->get();
          //  dd($products);die;
      //  var_dump(count($products));die;
           if(count($products) == 0 ) {
   //echo "test";die;
              return redirect()->back()->with('flash_message_error','The Searched Item Not Fount');
           }else {
           return view('products.listing')->with(compact('categories','products','search_product'));
         }

       }
}

} // End Class
