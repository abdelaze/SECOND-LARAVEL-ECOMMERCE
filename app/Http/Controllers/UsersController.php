<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
use Session;
use DB;
use App\Country;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function LoginRegister() {


       return view('users.login_register');

    }




   // register function
    public function register(Request $request) {

     if($request->isMethod('post')) {
      $data = $request->all();
          /*echo "<pre>"; print_r($data); die;*/
      // Check if User already exists
      $usersCount = User::where('email',$data['email'])->count();
      if($usersCount>0){
        return redirect()->back()->with('flash_message_error','Email already exists!');
      }else{

             $user = new User;
              $user->name = $data['name'];
              $user->email = $data['email'];
              $user->password = bcrypt($data['password']);
              $user->save();
               if(Auth::attempt(['email'=>$data['email'],'password'=>$data['password']])){
                    Session::put('frontSession',$data['email']);
                    if(!empty(Session::get('session_id'))){
                    $session_id = Session::get('session_id');
                    DB::table('cart')->where('session_id',$session_id)->update(['user_email' => $data['email']]);
                }
                    return redirect('/cart');
              }
      }

  }

}  //end register

//login function

public function login(Request $request){
       if($request->isMethod('post')){
           $data = $request->all();
           /*echo "<pre>"; print_r($data); die;*/
           if(Auth::attempt(['email'=>$data['email'],'password'=>$data['password']])){

              Session::put('frontSession',$data['email']);
              if(!empty(Session::get('session_id'))){
                    $session_id = Session::get('session_id');
                    DB::table('cart')->where('session_id',$session_id)->update(['user_email' => $data['email']]);
                }
               return redirect('/cart');

           }else{
               return redirect()->back()->with('flash_message_error','Invalid Username or Password!');
           }
       }
}

// logout function

 public function logout(){

      Auth::logout();
      Session::forget('frontSession');
      Session::forget('session_id');
      return redirect('/');
  }

   //check email
   public function checkEmail(Request $request) {

     $data = $request->all();
         $usersCount = User::where('email',$data['email'])->count();
         if($usersCount>0){
           echo "false";
         }else{
           echo "true"; die;
         }
   }

   // account function

   public function account(Request $request) {
      $countries = Country::get();
      $user_id = Auth::user()->id;
      $userDetails = User::find($user_id);
      if($request->isMethod('post')){
           $data = $request->all();
           /*echo "<pre>"; print_r($data); die;*/

           if(empty($data['name'])){
               return redirect()->back()->with('flash_message_error','Please enter your Name to update your account details!');
           }

           if(empty($data['address'])){
               $data['address'] = '';
           }

           if(empty($data['city'])){
               $data['city'] = '';
           }

           if(empty($data['state'])){
               $data['state'] = '';
           }

           if(empty($data['country'])){
               $data['country'] = '';
           }

           if(empty($data['pincode'])){
               $data['pincode'] = '';
           }

           if(empty($data['mobile'])){
               $data['mobile'] = '';
           }

           $user = User::find($user_id);
           $user->name = $data['name'];
           $user->address = $data['address'];
           $user->city = $data['city'];
           $user->state = $data['state'];
           $user->country = $data['country'];
           $user->pincode = $data['pincode'];
           $user->mobile = $data['mobile'];
           $user->save();
           return redirect()->back()->with('flash_success_message','Your account details has been successfully updated!');
       }

       return view('users.account')->with(compact('countries','userDetails'));
   }

 // check password

 public function chkUserPassword(Request $request){
        $data = $request->all();
        /*echo "<pre>"; print_r($data); die;*/
        $current_password = $data['current_pwd'];
        $user_id = Auth::User()->id;
        $check_password = User::where('id',$user_id)->first();
        if(Hash::check($current_password,$check_password->password)){
            echo "true"; die;
        }else{
            echo "false"; die;
        }
}

// update password
public function updatePassword(Request $request){
       if($request->isMethod('post')){
           $data = $request->all();
           /*echo "<pre>"; print_r($data); die;*/
           $old_pwd = User::where('id',Auth::User()->id)->first();
           $current_pwd = $data['current_pwd'];
           if(Hash::check($current_pwd,$old_pwd->password)){
               // Update password
               $new_pwd = bcrypt($data['new_pwd']);
               User::where('id',Auth::User()->id)->update(['password'=>$new_pwd]);
               return redirect()->back()->with('flash_success_message',' Password updated successfully!');
           }else{
               return redirect()->back()->with('flash_message_error','Current Password is incorrect!');
           }
       }
  }

} //end of the class
