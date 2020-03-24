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
            <h5>Products</h5>
          </div>
          <div class="widget-content nopadding">
            <table class="table table-bordered data-table">
              <thead>
                <tr>
                  <th>Product ID</th>
                  <th>Category_id</th>
                  <th>Category_Name</th>
                  <th>Product Name</th>
                  <th>Product Code</th>
                  <th>Product Color</th>
                  <th>Product Price</th>
                  <th>Product Image</th>

                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach($products as $product)


                <tr class="gradeX">
                  <td>{{$product->id}}</td>
                  <td>{{$product->category_id}}</td>
                  <td>{{$product->category->category_name}}</td>
                  <td>{{$product->product_name}}</td>
                  <td>{{$product->product_code}}</td>
                  <td>{{$product->product_color}}</td>
                  <td>{{$product->price}}</td>
                  <td>
                    @if(!empty($product->image))
                      <img src="{{asset('images/backend_images/product/small/'.$product->image)}}" class="img-responsive center-block" style="width:50px;height:50px;">
                   @endif

                  </td>
                  <td class="center">

                     <a href="#myModal{{$product->id}}" data-toggle="modal" class="btn btn-success btn-mini">View</a>
                     <a href="{{url('/admin/edit_product/'.$product->id)}}" class="btn btn-primary btn-mini">Edit</a>
                     <a href="{{url('/admin/add_attributes/'.$product->id)}}" class="btn btn-primary btn-mini" title="Add Attributes">Add</a>
                      <a href="{{url('/admin/add_images/'.$product->id)}}" class="btn btn-info btn-mini" title="Add Images">Add</a>
                     <!-- <a href="{{url('/admin/delete_product/'.$product->id)}}" class="btn btn-danger btn-mini" id="del_cat">Delete</a> -->
                     <a id="delProduct" rel="{{ $product->id }}" rel1="delete_product" href="javascript:"  class="btn btn-danger btn-mini deleteRecord">Delete</a>

                  </td>
                </tr>

                <div id="myModal{{$product->id}}" class="modal hide">
                    <div class="modal-header">
                       <button data-dismiss="modal" class="close" type="button">×</button>
                       <h3>{{$product->product_name}} Full Details</h3>
                    </div>
                    <div class="modal-body">
                      <p>Product ID: {{ $product->id }}</p>
                           <p>Category ID: {{ $product->category_id }}</p>
                           <p>Product Code: {{ $product->product_code }}</p>
                           <p>Product Color: {{ $product->product_color }}</p>
                           <p>Price: {{ $product->price }}</p>
                           <p>Fabric: </p>
                           <p>Pattern: </p>
                           <p>Description: {{ $product->description }}</p>
                    </div>
               </div>

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
