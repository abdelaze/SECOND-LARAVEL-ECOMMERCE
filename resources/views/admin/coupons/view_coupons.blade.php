@extends('layouts.adminLayout.admin_design')
@section('content')
<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#" class="current">Tables</a> </div>
    <h1>Products</h1>
  </div>
  <div class="container-fluid">


      @if (Session::has('flash_success_message'))
            <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{!!Session('flash_success_message')!!}</strong>
            </div>
     @endif
    <hr>
    <div class="row-fluid">
      <div class="span12">

        <div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
            <h5>Coupons</h5>
          </div>
          <div class="widget-content nopadding">
            <table class="table table-bordered data-table">
              <thead>
                <tr>
                  <th>Coupon ID</th>
                  <th>Coupon Code</th>
                  <th>Amount</th>
                  <th>Amount Type</th>
                  <th>Expiry Date</th>
                  <th>Create Date</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach($coupons as $coupon)


                <tr class="gradeX">
                  <td>{{$coupon->id}}</td>
                  <td>{{$coupon->coupon_code}}</td>
                  <td>
                    @if($coupon->amount_type == "precentage") % @else $ @endif
                    {{$coupon->amount}}
                  </td>
                  <td>{{$coupon->amount_type}}</td>
                  <td>{{$coupon->expiry_date}}</td>
                  <td>{{$coupon->created_at}}</td>
                  <td>
                    @if($coupon->status == 1) active @else inactive @endif
                  </td>

                  <td class="center">


                     <a href="{{url('/admin/edit_coupon/'.$coupon->id)}}" class="btn btn-primary btn-mini">Edit</a>

                     <a id="delProduct" rel="{{ $coupon->id }}" rel1="delete_coupon" href="javascript:"  class="btn btn-danger btn-mini deleteRecord">Delete</a>

                  </td>
                </tr>

                 @endforeach

              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection
