<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Auth;
use Session;
use App\User;
use Illuminate\Support\Facades\Hash;
use App\Admin;
class AdminController extends Controller
{
    public function login(Request $request){

      if($request->isMethod('post')) {

          $data = $request->input();

          $adminCount = Admin::where(['email' => $data['email'],'password'=>md5($data['password']),'status'=>1])->count();
           if($adminCount > 0){
               //echo "Success"; die;
               Session::put('adminSession', $data['email']);
               return redirect('/admin/dashboard');
         }else {
            //  echo 'failed'; die;
               return redirect('/admin')->with('flash_error_message','Invalid Username Or Password');
           }

      }

        return view('admin.admin_login');
    }

    public function dashboard (){
         /*if(Session::has('adminLogin')){

         }else{
            return redirect('/admin')->with('flash_error_message','please login to access dashboard');
         }*/
         return view('admin.admin_dashboard');

    }

    public function logout(){
        Session::flush();
        return redirect('/admin')->with('flash_success_message','logged out successfuly');
    }



    public function settings(){

      $adminDetails = Admin::where(['email'=>Session::get('adminSession')])->first();

       //echo "<pre>"; print_r($adminDetails); die;

       return view('admin.settings')->with(compact('adminDetails'));
  }


    public function chkPassword(Request $request){
     $data = $request->all();
     //echo "<pre>"; print_r($data); die;
     //echo "<pre>"; print_r($data); die;
       $adminCount = Admin::where(['email' => Session::get('adminSession'),'password'=>md5($data['current_pwd'])])->count();
           if ($adminCount == 1) {
               //echo '{"valid":true}';die;
               echo "true"; die;
           } else {
               //echo '{"valid":false}';die;
               echo "false"; die;
           }
 }

 public function updatePassword(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;
            //echo "<pre>"; print_r($data); die;
            $adminCount = Admin::where(['email' => Session::get('adminSession'),'password'=>md5($data['current_pwd'])])->count();

            if ($adminCount == 1) {
                // here you know data is valid
                $password = md5($data['new_pwd']);
                Admin::where('email',Session::get('adminSession'))->update(['password'=>$password]);
                return redirect('/admin/settings')->with('flash_success_message', 'Password updated successfully.');
            }else{
                return redirect('/admin/settings')->with('flash_message_error', 'Current Password entered is incorrect.');
            }


        }
}




}//end controller
