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

 @if(Session::has('flash_message_error'))
           <div class="alert alert-error alert-block">
               <button type="button" class="close" data-dismiss="alert">×</button>
                   <strong>{!! session('flash_message_error') !!}</strong>
           </div>
 @endif

  <hr>
  <div class="row-fluid">
    <div class="span12">
      <div class="widget-box">
        <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
          <h5>Add Images</h5>
        </div>
        <div class="widget-content nopadding">
          <form action="{{url('/admin/add_images/'.$productDetails->id)}}" method="post" class="form-horizontal" enctype="multipart/form-data" id="add_imagess">
            {{ csrf_field() }}
            <input type="hidden" name="product_id" value="{{$productDetails->id}}">
            <div class="control-group">
                <label class="control-label">Product Name</label>
                <label class="control-label">{{ $productDetails->product_name }}</label>
              </div>
              <div class="control-group">
                <label class="control-label">Product Code</label>
                <label class="control-label">{{ $productDetails->product_code }}</label>
              </div>
              <div class="control-group">
                <label class="control-label">Product Color</label>
                <label class="control-label">{{ $productDetails->product_color }}</label>
              </div>
              <div class="control-group">
                 <label class="control-label">Product Alt Image(s)</label>
                 <div class="controls">
                  <input type="file" name="image[]" id="image"  multiple="multiple">
                 </div>
               </div>


       <div class="form-actions">
         <input type="submit" value="Add Images" class="btn btn-success">
       </div>









          </form>
        </div>
      </div>


    </div>



  </div>


  <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
            <h5>Aternate Images</h5>
          </div>
          <div class="widget-content nopadding">

              <table class="table table-bordered data-table">
                <thead>
                  <tr>
                    <th>Imagr ID</th>
                    <th>Product_ID</th>
                    <th>IMAGE</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($images as $image)
                  <tr class="gradeX">
                    <td class="center">{{ $image->id }}</td>
                    <td class="center">{{ $image->product_id }}</td>
                    <td>
                      @if(!empty($image->image))
                        <img src="{{asset('images/backend_images/product/small/'.$image->image)}}" class="img-responsive center-block" style="width:80px;height:80px;">
                     @endif

                    </td>

                    <td class="center">
                     <a id="delImg" rel="{{ $image->id }}" rel1="delete_alt_image" href="javascript:"  class="btn btn-danger btn-mini deleteRecord">Delete</a>
                    </td>

                  </tr>
                  @endforeach

                </tbody>
              </table>
            </form>
          </div>
        </div>
      </div>
    </div>
</div>
</div>


@endsection
