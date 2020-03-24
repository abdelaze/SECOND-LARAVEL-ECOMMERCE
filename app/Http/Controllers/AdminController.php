<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Auth;
use Session;
use App\User;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function login(Request $request){

      if($request->isMethod('post')) {

          $data = $request->input();
           if (Auth::attempt(['email' =>$data['email'] , 'password' =>$data['password'] ,'admin' =>'1' ])) {

                //echo 'succeeed'; die;
              //  Session::put('adminLogin',$data['email']);
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

       return view('admin.settings');

    }


    public function chkPassword(Request $request){
     $data = $request->all();
     //echo "<pre>"; print_r($data); die;
     $current_password = $data['current_pwd'];
     $check_password = User::where(['admin'=>'1'])->first();
         if (Hash::check($current_password, $check_password->password)) {
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
            $check_password = User::where(['email'=>Auth::user()->email])->first();
            $current_password = $data['current_pwd'];

            if (Hash::check($current_password, $check_password->password)) {
                // here you know data is valid
                $password = bcrypt($data['new_pwd']);
                User::where('id','1')->update(['password'=>$password]);
                return redirect('/admin/settings')->with('flash_success_message', 'Password updated successfully.');
            }else{
                return redirect('/admin/settings')->with('flash_error_message', 'Current Password entered is incorrect.');
            }


        }
    }




}//end controller
