<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Coupon;
class CouponsController extends Controller
{
    public function addCoupon(Request $request) {

         if($request->isMethod('post')) {
             $data = $request->all();
             $coupon = New Coupon;
             $coupon->coupon_code = $data['coupon_code'];
             $coupon->amount= $data['amount'];
             $coupon->amount_type = $data['amount_type'];
             $coupon->expiry_date = $data['expiry_date'];
             $coupon->status = $data['status'];
             $coupon->save();
             return redirect()->action('CouponsController@viewCoupons')->with('flash_success_message','Coupons add successfully!');

         }

         return view('admin.coupons.add_coupon');
    } // end add function

  public function viewCoupons(){
     $coupons = Coupon::get();
     return view('admin.coupons.view_coupons')->with(compact('coupons'));
  } // end view function

  public function editCoupon(Request $request , $id = null) {

    if($request->isMethod('post')) {
        $data = $request->all();
        $coupon = Coupon::find($id);
        $coupon->coupon_code = $data['coupon_code'];
        $coupon->amount= $data['amount'];
        $coupon->amount_type = $data['amount_type'];
        $coupon->expiry_date = $data['expiry_date'];
        if(empty($data['statust'])) {
             $data['statust'] = 0 ;
        }

            $coupon->status = $data['status'];

        $coupon->save();
        return redirect()->action('CouponsController@viewCoupons')->with('flash_success_message','Coupons Updated successfully!');

    }

     $couponDetails = Coupon::find($id);
     return view('admin.coupons.edit_coupon')->with(compact('couponDetails'));
  }

public function deleteCoupon($id = null) {
   Coupon::where('id',$id)->delete();
   return redirect()->action('CouponsController@viewCoupons')->with('flash_success_message','Coupons Has bee Deleted successfully!');

}



} // end of the class
