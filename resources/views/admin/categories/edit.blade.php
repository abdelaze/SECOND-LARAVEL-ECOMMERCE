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
          <h5>Edit Category</h5>
        </div>
        <div class="widget-content nopadding">
          <form action="{{url('/admin/update_category/'.$category->id)}}" method="post" class="form-horizontal">
            {{ csrf_field() }}
            <div class="control-group">
                 <label class="control-label">Category Name</label>
                 <div class="controls">
                   <input type="text" name="category_name" id="category_name" value="{{$category->category_name}}" required>
                 </div>
               </div>

               <div class="control-group">
                 <label class="control-label">Description</label>
                 <div class="controls">
                   <textarea name="description" required>{{$category->description}}</textarea>
                 </div>
               </div>

               <div class="control-group">
               <label class="control-label">Category Level</label>
               <div class="controls">
                 <select name="parent_id" style="width:220px;">
                   <option value="0">Main Category</option>
                   @foreach($levels as $val)
                   <option value="{{ $val->id }}" @if($val->id==$category->parent_id) selected @endif > {{ $val->category_name }}</option>
                   @endforeach
                 </select>
               </div>
             </div>


               <div class="control-group">
                 <label class="control-label">URL</label>
                 <div class="controls">
                   <input type="text" name="url" id="url" required value="{{$category->url}}">
                 </div>
               </div>

               <div class="control-group">
                 <label class="control-label">Enable</label>
                 <div class="controls">
                   <input type="checkbox" name="status" id="status" @if($category->status==1) checked @endif value="1">
                 </div>
               </div>

               <div class="form-actions">
                 <input type="submit" value="Update Category" class="btn btn-success">
               </div>
          </form>
        </div>
      </div>


    </div>

  </div>

</div></div>
@endsection
