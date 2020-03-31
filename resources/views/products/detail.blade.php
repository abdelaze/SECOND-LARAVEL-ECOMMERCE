@extends('layouts.frontlayout.front_design')

@section('content')

<section>
		<div class="container">
			<div class="row">
				@if (Session::has('flash_success_message'))
              <div class="alert alert-success alert-block">
              <button type="button" class="close" data-dismiss="alert">×</button>
              <strong>{!!Session('flash_success_message')!!}</strong>
              </div>
       @endif

       @if(Session::has('flash_message_error'))
                 <div class="alert alert-error alert-block" style="background:red;color:#fff;">
                     <button type="button" class="close" data-dismiss="alert">×</button>
                         <strong>{!! session('flash_message_error') !!}</strong>
                 </div>
       @endif
				<div class="col-sm-3">
        @include('layouts.frontlayout.front_side')
        </div>

				<div class="col-sm-9 padding-right">
					<div class="product-details"><!--product-details-->
						<div class="col-sm-5">
							<div class="view-product">
								<div class="easyzoom easyzoom--overlay easyzoom--with-thumbnails">
			            	<a href="{{asset('images/backend_images/product/medium/'.$productDetails->image)}}">
				               	<img class="mainImage" style="width:300px;" src="{{asset('images/backend_images/product/medium/'.$productDetails->image)}}" alt="" />
			             	</a>
		           </div>

								<h3>ZOOM</h3>
						</div>
							<div id="similar-product" class="carousel slide" data-ride="carousel">

								  <!-- Wrapper for slides -->
								    <div class="carousel-inner">


                   <div class='item active thumbnails'>
										 <a href="{{asset('images/backend_images/product/medium/'.$productDetails->image)}}" data-standard="{{asset('images/backend_images/product/medium/'.$productDetails->image)}}">
												<img class="changeImage" style="width:80px;" src="{{asset('images/backend_images/product/medium/'.$productDetails->image)}}" alt="" />
										</a>
										<?php


											  for($x=0;$x<2;$x++){

												     	if(empty($productaltimages[$x]['image'])) {
														 break;
													}?>
													<a href="{{asset('images/backend_images/product/medium/'.$productaltimages[$x]['image'])}}" data-standard="{{asset('images/backend_images/product/medium/'.$productaltimages[$x]['image'])}}">
													<img class="changeImage" style="width:80px;cursor:pointer;" src="{{asset('images/backend_images/product/small/'.$productaltimages[$x]['image'])}}" alt="">
												</a>
											<?php	}

										 ?>

									</div>


										 <?php

                         for($i=2;$i<$count;$i+=3){

															echo "<div class='item thumbnails'>";


													 	 for($j=$i;$j<$i+3;$j++) {
                                if(empty($productaltimages[$j]['image'])) {
																	 break;
																}else {

																?>
																   <a href="{{asset('images/backend_images/product/medium/'.$productaltimages[$j]['image'])}}" data-standard="{{asset('images/backend_images/product/medium/'.$productaltimages[$j]['image'])}}">
																	 <img class="changeImage" style="width:80px;cursor:pointer;" src="{{asset('images/backend_images/product/small/'.$productaltimages[$j]['image'])}}" alt="">
																 </a>
															<?php	}

											     	}

                     echo "</div>";

								}


					 ?>






				 </div>

								  <!-- Controls -->
								   <a class="left item-control" href="#similar-product" data-slide="prev">
									<i class="fa fa-angle-left"></i>
								  </a>
								  <a class="right item-control" href="#similar-product" data-slide="next">
									<i class="fa fa-angle-right"></i>
								  </a>
							</div>

						</div>
						<div class="col-sm-7">

							<form name="addtoCartForm" id="addtoCartForm" action="{{ url('add_cart') }}" method="post">
								{{ csrf_field() }}
                <input type="hidden" name="product_id" value="{{ $productDetails->id }}">
                <input type="hidden" name="product_name" value="{{ $productDetails->product_name }}">
                <input type="hidden" name="product_code" value="{{ $productDetails->product_code }}">
                <input type="hidden" name="product_color" value="{{ $productDetails->product_color }}">
                <input type="hidden" name="price" id="price" value="{{ $productDetails->price }}">
							<div class="product-information"><!--/product-information-->
								<img src="{{asset('images/frontend_images/product-details/new.jpg')}}" class="newarrival" alt="" />
								<h2>{{$productDetails->product_name}}</h2>
								<p>{{$productDetails->product_code}}</p>
								<p><img src="{{asset('images/frontend_images/product-details/rating.png')}}" alt="" /></p>
								<span>
									<p>

										<select id="selSize" name="size" style="width:150px;" required>

											<option value="">Select Size</option>

											@foreach($productDetails->attributes as $sizes)
											<option value="{{ $productDetails->id }}-{{ $sizes->size }}">{{ $sizes->size }}</option>
											@endforeach
										</select>
									</p>
                  <p>
									<span id="getPrice">INR {{$productDetails->price}}</span>
									<label>Quantity:</label>
									<input type="text" name="quantity" value="1" />
									@if($totalstock >0 )
									<button type="submit" class="btn btn-fefault cart" id="cartButton">
										<i class="fa fa-shopping-cart"></i>
										Add to cart
									</button>
								</p>
									@endif
								</span>
								<p><b>Availability:</b> <span id="availability">	@if($totalstock >0 ) In Stock @else Out Of Stock @endif</span></p>
								<p><b>Condition:</b> New</p>

								<a href=""><img src="{{asset('images/frontend_images/product-details/share.png')}}" class="share img-responsive"  alt="" /></a>
							</div><!--/product-information-->
						</form>
						</div>
					</div><!--/product-details-->

					<div class="category-tab shop-details-tab"><!--category-tab-->
						<div class="col-sm-12">
							<ul class="nav nav-tabs">
								<li class="active"><a href="#description" data-toggle="tab">Description</a></li>
								<li><a href="#care" data-toggle="tab">Material</a></li>
								<li><a href="#delivery" data-toggle="tab">Delivery</a></li>

							</ul>
						</div>
						<div class="tab-content">
							<div class="tab-pane fade active in" id="description" >
								<div class="col-sm-12">

									   <p>
                   {{$productDetails->description}}
										 </p>

								</div>

							</div>

							<div class="tab-pane fade" id="care" >
								<div class="col-sm-12">
									<p>
								{{$productDetails->care}}
									</p>
								</div>

							</div>


							<div class="tab-pane fade" id="delivery" >
								<div class="col-sm-12">
									<p>
										100% Original Products
										Free Delivery on order above Rs. 1199
										Cash on delivery might be available
										Easy 30 days returns and exchanges
										Try & Buy might be available
									</p>
								</div>

							</div>







						</div>
					</div><!--/category-tab-->

					<div class="recommended_items"><!--recommended_items-->
						<h2 class="title text-center">recommended items</h2>

						<div id="recommended-item-carousel" class="carousel slide" data-ride="carousel">
							<div class="carousel-inner">

								`	<?php $count=1; ?>
								 @foreach($relatedProducts->chunk(3) as $chunk)
								 <div <?php if($count==1){ ?> class="item active" <?php } else { ?> class="item" <?php } ?>>
									 @foreach($chunk as $item)
									 <div class="col-sm-4">
										 <div class="product-image-wrapper">
											 <div class="single-products">
												 <div class="productinfo text-center">
													 <img style="width:200px;" src="{{ asset('images/backend_images/product/small/'.$item->image) }}" alt="" />
													 <h2>INR {{ $item->price }}</h2>
													 <p>{{ $item->product_name }}</p>
													 <a href="{{ url('/product/'.$item->id) }}"><button type="button" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</button></a>
												 </div>
											 </div>
										 </div>
									 </div>
									 @endforeach
								 </div>
								 <?php $count++; ?>
								 @endforeach`


						</div>



							 <a class="left recommended-item-control" href="#recommended-item-carousel" data-slide="prev">
								<i class="fa fa-angle-left"></i>
							  </a>
							  <a class="right recommended-item-control" href="#recommended-item-carousel" data-slide="next">
								<i class="fa fa-angle-right"></i>
							  </a>
						</div>
					</div><!--/recommended_items-->



				</div>
			</div>
		</div>
		</div>


	</section>










@endsection
