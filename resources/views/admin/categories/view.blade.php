@extends('layouts.adminLayout.admin_design')
@section('content')
<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#" class="current">Tables</a> </div>
    <h1>Tables</h1>
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
            <h5>Categories</h5>
          </div>
          <div class="widget-content nopadding">
            <table class="table table-bordered data-table">
              <thead>
                <tr>
                  <th>Category ID</th>
                  <th>Category Name</th>
                  <th>Category Level</th>
                  <th>Category URL</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach($categories as $category)


                <tr class="gradeX">
                  <td>{{$category->id}}</td>
                  <td>{{$category->category_name}}</td>
                  <td>{{$category->parent_id}}</td>
                  <td>{{$category->url}}</td>
                  <td class="center">

                      <a href="{{url('/admin/update_category/'.$category->id)}}" class="btn btn-primary btn-mini">Edit</a>
                     <!-- <a href="{{url('/admin/delete_category/'.$category->id)}}" class="btn btn-danger btn-mini" id="del_cat">Delete</a> -->
                     <a id="delcat" rel="{{ $category->id }}" rel1="delete_category" href="javascript:"  class="btn btn-danger btn-mini deleteRecord">Delete</a>

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
