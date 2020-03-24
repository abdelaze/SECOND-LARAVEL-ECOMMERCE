@extends('layouts.adminLayout.admin_design')
@section('content')

<div id="content">
 <div id="content-header">
   <div id="breadcrumb"> <a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#">Form elements</a> <a href="#" class="current">Validation</a> </div>
   <h1>Form validation</h1>
 </div>
 <div class="container-fluid"><hr>
   @if (Session::has('flash_error_message'))
         <div class="alert alert-danger alert-block">
         <button type="button" class="close" data-dismiss="alert">×</button>
         <strong>{!!Session('flash_error_message')!!}</strong>
         </div>
  @endif

  @if (Session::has('flash_success_message'))
        <div class="alert alert-success alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>{!!Session('flash_success_message')!!}</strong>
        </div>
 @endif
   <div class="row-fluid">
     <div class="span12">

     <div class="row-fluid">
       <div class="span12">
         <div class="widget-box">
           <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
             <h5>Security validation</h5>
           </div>
           <div class="widget-content nopadding">


             <form class="form-horizontal" method="post" action="{{url('/admin/update_pwd')}}" name="password_validate" id="password_validate" novalidate="novalidate">
                {{csrf_field()}}


               <div class="control-group">
                 <label class="control-label">Password</label>
                 <div class="controls">
                   <input type="password" name="current_pwd" id="current_pwd"/>
                   <span id="chkPwd"></span>
                 </div>
               </div>
               <div class="control-group">
                 <label class="control-label">Password</label>
                 <div class="controls">
                   <input type="password" name="new_pwd" id="new_pwd" />
                 </div>
               </div>
               <div class="control-group">
                 <label class="control-label">Confirm password</label>
                 <div class="controls">
                   <input type="password" name="confirm_pwd" id="confirm_pwd" />
                 </div>
               </div>
               <div class="form-actions">
                 <input type="submit" value="Update Password" class="btn btn-success">
               </div>
             </form>
           </div>
         </div>
       </div>
     </div>
   </div>
 </div>
</div>
</div>
@endsection
