<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;

class CategoryController extends Controller
{

   public function index()
    {
        $categories = Category::get();
      //  $categories = json_decode(json_encode('categories'));
        return view('admin.categories.view')->with(compact('categories'));


    }

  public function addCategory(Request $request){


    if($request->isMethod('post')){

    //  echo $request->input('status'); die;
      $data = $this->validate(request(),[
            'category_name' =>'required',
            'description' =>'required',
            'url'   =>'required',
            'parent_id'   =>'required',]);

         if(empty( $request->input('status'))) {
              $data['status'] = 0;
         }else {
             $data['status'] = 1;
         }
          // echo $data['status']; die;
           Category::create($data);

         return redirect('/admin/add_category')->with('flash_success_message','Category added successfuly');

  }
     $levels = Category::where(['parent_id'=>0])->get();
    return view('admin.categories.create')->with(compact('levels'));
  }




    public function updateCategory(Request $request, $id)
    {

          $category = Category::find($id);

          if($request->isMethod('post')){
                $data = $request->all();
                if(empty( $request->input('status'))) {
                     $data['status'] = 0;
                }else {
                    $data['status'] = 1;
                }
                Category::where(['id'=>$id])->update(['category_name'=>$data['category_name'],'parent_id'=>$data['parent_id'],'description'=>$data['description'],'url'=>$data['url'],'status'=>$data['status']]);
              return redirect('/admin/view_category')->with('flash_success_message','Category updated successfuly');
     }

      $levels = Category::where(['parent_id'=>0])->get();
       return view('admin.categories.edit')->with(compact('category','levels'));
  }


    public function deleteCategory($id)
    {
        $cat = Category::find($id);
        $cat->delete();
        return redirect()->back()->with('flash_success_message','Category deleted successfuly');
    }
}
