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
          <h5>Add Product</h5>
        </div>
        <div class="widget-content nopadding">
          <form action="{{url('/admin/add_product')}}" method="post" class="form-horizontal" enctype="multipart/form-data" id="add_product">
            {{ csrf_field() }}

            <div class="control-group">
         <label class="control-label">Under Category</label>
         <div class="controls">
           <select name="category_id" id="category_id" style="width:220px;">
             <?php echo $categories_drop_down; ?>
           </select>
         </div>
       </div>
       <div class="control-group">
         <label class="control-label">Product Name</label>
         <div class="controls">
           <input type="text" name="product_name" id="product_name">
         </div>
       </div>
       <div class="control-group">
         <label class="control-label">Product Code</label>
         <div class="controls">
           <input type="text" name="product_code" id="product_code">
         </div>
       </div>
       <div class="control-group">
         <label class="control-label">Product Color</label>
         <div class="controls">
           <input type="text" name="product_color" id="product_color">
         </div>
       </div>
       <div class="control-group">
         <label class="control-label">Description</label>
         <div class="controls">
           <textarea name="description"></textarea>
         </div>
       </div>

       <div class="control-group">
         <label class="control-label">Material & Care </label>
         <div class="controls">
           <textarea name="care"></textarea>
         </div>
       </div>

       <div class="control-group">
         <label class="control-label">Price</label>
         <div class="controls">
           <input type="text" name="price" id="price">
         </div>
       </div>
       <div class="control-group">
         <label class="control-label">Image</label>
         <div class="controls">
           <div class="uploader" id="uniform-undefined"><input name="image" id="image" type="file" size="19" style="opacity: 0;"><span class="filename">No file selected</span><span class="action">Choose File</span></div>
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
