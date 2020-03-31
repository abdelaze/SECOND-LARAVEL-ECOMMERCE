<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Banner;
use Image;

class BannersController extends Controller
{

   //add banners
    public function addBanner(Request $request) {
      if($request->isMethod('post')){
             $data = $request->all();
     //echo "<pre>"; print_r($data); die;

           $banner = new Banner;
            $banner->title = $data['title'];
            $banner->link = $data['link'];

               if(empty($data['status'])){
                   $status='0';
               }else{
                   $status='1';
               }

         // Upload Image
               if($request->hasFile('image')){
                 $image_tmp = $request->file('image');
                   if ($image_tmp->isValid()) {
                       // Upload Images after Resize
                       $extension = $image_tmp->getClientOriginalExtension();
                      $fileName = rand(111,99999).'.'.$extension;
                       $banner_path = 'images/frontend_images/banners/'.$fileName;
                       Image::make($image_tmp)->resize(1140, 340)->save($banner_path);
                       $banner->image = $fileName;
                   }
               }

               $banner->status = $status;
               $banner->save();
               return redirect()->back()->with('flash_success_message', 'Banner has been added successfully');
        }
                return view('admin.banners.add_banners');
  }


//View Banners
public function viewBanners(){
          $banners = Banner::get();
          return view('admin.banners.view_banners')->with(compact('banners'));
}


//edit Banner
public function editBanner(Request $request, $id=null){
     if($request->isMethod('post')){
         $data = $request->all();
         /*echo "<pre>"; print_r($data); die;*/

         if(empty($data['status'])){
             $status='0';
         }else{
             $status='1';
         }

         if(empty($data['title'])){
             $data['title'] = '';
         }

         if(empty($data['link'])){
             $data['link'] = '';
         }

         // Upload Image
         if($request->hasFile('image')){
             $image_tmp = $request->file('image');
             if ($image_tmp->isValid()) {
                 // Upload Images after Resize
                 $extension = $image_tmp->getClientOriginalExtension();
                 $fileName = rand(111,99999).'.'.$extension;
                 $banner_path = 'images/frontend_images/banners/'.$fileName;
                 Image::make($image_tmp)->resize(1140, 340)->save($banner_path);
             }
         }else if(!empty($data['current_image'])){
             $fileName = $data['current_image'];
         }else{
             $fileName = '';
         }


         Banner::where('id',$id)->update(['status'=>$status,'title'=>$data['title'],'link'=>$data['link'],'image'=>$fileName]);
         return redirect()->back()->with('flash_success_message','Banner has been edited Successfully');

     }
     $bannerDetails = Banner::where('id',$id)->first();
     return view('admin.banners.edit_banner')->with(compact('bannerDetails'));
 }

 //delete Banner

 public function deleteBanner($id = null){
         Banner::where(['id'=>$id])->delete();
         return redirect()->back()->with('flash_success_message', 'Banner has been deleted successfully');
}




} //ens class
