@extends('layouts.frontlayout.front_design')

@section('content')

<section id="cart_items">
   <div class="container">
     <div class="breadcrumbs">
       <ol class="breadcrumb">
         <li><a href="#">Home</a></li>
         <li class="active">Shopping Cart</li>
       </ol>

     </div>
     <div class="table-responsive">
          <table id="cart_info" class="table table-bordered table-striped">
              <thead>
               <tr>
                 <thead>
                   <tr class="cart_menu">
                     <th>ID</td>
                     <th>ProductName</th>
                     <th>Price</th>
                     <th>Quantity</th>
                     <th>Total</th>
                     <th></th>
                   </tr>
                 </thead>
               </tr>
              </thead>
              <?php $total_amount = 0; ?>
          </table>


  </div>


   </div>

 </section> <!--/#cart_items-->



 <section id="do_action">
   <div class="container">
     <div class="heading">
       <h3>What would you like to do next?</h3>
       <p>Choose if you have a coupon code or reward points you want to use or would like to estimate your delivery cost.</p>
     </div>
     <div class="row">
       <div class="col-sm-6">
         <div class="chose_area">

                <ul class="user_option">
                <li>
                  <form action="{{ url('cart/apply_coupon') }}" method="post">
                    {{ csrf_field() }}
                    <label>Coupon Code</label>
                    <input type="text" name="coupon_code" autocomplete="off">
                    <input type="submit" value="Apply" class="btn btn-default">
                  </form>
                </li>
              </ul>
         </div>
       </div>
       <div class="col-sm-6">
         <div class="total_area">
           <ul>
             @if(!empty(Session::get('CouponAmount')))
                <li>Sub Total <span>$<?php echo $total_amount; ?></span></li>
                <li>Coupon Discount <span>$ <?php echo Session::get('CouponAmount'); ?></span></li>
                <li>Grand Total <span>$<?php echo $total_amount - Session::get('CouponAmount'); ?></span></li>
              @else
                <li>Grand Total <span>$<?php echo $total_amount; ?></span></li>
              @endif
           </ul>
             <a class="btn btn-default update" href="">Update</a>
             <a class="btn btn-default check_out" href="{{url('/checkout')}}">Check Out</a>
         </div>
       </div>
     </div>
   </div>
 </section><!--/#do_action-->


<script>
$(document).ready(function(){

       $('#cart_info').DataTable({
        processing: true,
        serverSide: true,
        ajax:"{{ url('cart2') }}",

        columns: [
          {
            name:'id',
            data:'id',

          },
          {
             name:'product_name',
             data:'product_name',

          },
          {
              name:'price',
              data:'price',

          },
          {
              name:'quantity',
             data:'quantity',

          },

          {
            data: 'action',
            name: 'action',
           orderable: false
       },





        ]
       });

});
</script>


 @endsection
