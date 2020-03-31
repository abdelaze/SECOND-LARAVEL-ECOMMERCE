@extends('layouts.adminLayout.admin_design')
@section('content')

<div id="content">
<div id="content-header">
  <div id="breadcrumb"> <a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#" class="tip-bottom">Form elements</a> <a href="#" class="current">Common elements</a> </div>
  <h1>Common Form Elements</h1>
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
        <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
          <h5>Add Coupon</h5>
        </div>
        <div class="widget-content nopadding">
          <form action="{{url('/admin/add_coupons')}}" method="post" class="form-horizontal"  id="add_coupon">
            {{ csrf_field() }}


       <div class="control-group">
         <label class="control-label">Coupon Code</label>
         <div class="controls">
           <input type="text" name="coupon_code" id="coupon_code" minlength="5" maxlength="15" required>
         </div>
       </div>
       <div class="control-group">
         <label class="control-label">Amount</label>
         <div class="controls">
           <input type="number" name="amount" id="amount" min="0" required>
         </div>
       </div>
       <div class="control-group">
         <label class="control-label">Amount Type</label>
         <div class="controls">
           <select name="amount_type" id="amount_type" style="width:220px;" required>
                 <option value="precentage">precentage</option>
                 <option value="fixed">fixed</option>
           </select>
         </div>
       </div>

       <div class="control-group">
         <label class="control-label">Expiry Date</label>
         <div class="controls">
           <input type="text" name="expiry_date" id="expiry_date" autocomplete="off" required>
         </div>
       </div>


       <div class="control-group">
         <label class="control-label">Enable</label>
         <div class="controls">
           <input type="checkbox" name="status" id="status" value="1">
         </div>
       </div>

       <div class="form-actions">
         <input type="submit" value="Add Product" class="btn btn-success">
       </div>









          </form>
        </div>
      </div>


    </div>

  </div>

</div></div>
@endsection
