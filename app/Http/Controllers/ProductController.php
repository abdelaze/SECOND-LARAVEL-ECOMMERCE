<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Auth;
use Session;
use Image;
use App\Category;
use App\Product;
use App\ProductAttribute;
use App\ProductsImage;

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
                Product::where(['id'=>$id])->update(['category_id'=>$data['category_id'],'product_name'=>$data['product_name'],
                'product_code'=>$data['product_code'],'product_color'=>$data['product_color'],'description'=>$data['description'],'care'=>$data['care'],'price'=>$data['price'],'image'=>$fileName]);

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
          $products = Product::whereIn('category_id',$subcatsid)->get();
      //  echo $subcatsid; die;
    }else {
     $products = Product::where(['category_id'=>$categoryDetails->id])->get();
   }
    return view('products.listing')->with(compact('products','categoryDetails','categories'));
} // end products

// product detail

public function product($id=null) {

     $productDetails = Product::with('attributes')->where('id',$id)->first();
     $categories = Category::with('categories')->where(['parent_id'=>'0'])->get();
     $productaltimages = ProductsImage::where(['product_id'=>$id])->get();
     $count = ProductsImage::where(['product_id'=>$id])->count();
    // echo $count; die;
     return view('products.detail')->with(compact('productDetails','categories','productaltimages','count'));

}

// get product pricr and we will write code in main.js
public function getProductPrice(Request $request) {

    $data = $request->all();

    $proArr = explode("-",$data['idsize']);
    $proAttr = ProductAttribute::where(['product_id'=>$proArr[0],'size'=>$proArr[1]])->first();
    echo $proAttr->price; // this result i will use it in ajax and put it in price  echo mean response it is important

}

} // End Class