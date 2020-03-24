@extends('layouts.frontlayout.front_design')

@section('content')

<section>
		<div class="container">
			<div class="row">
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

											  for($x=0;$x<2;$x++){?>
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
							<div class="product-information"><!--/product-information-->
								<img src="{{asset('images/frontend_images/product-details/new.jpg')}}" class="newarrival" alt="" />
								<h2>{{$productDetails->product_name}}</h2>
								<p>{{$productDetails->product_code}}</p>
								<img src="{{asset('images/frontend_images/product-details/rating.png')}}" alt="" />
								<span>
									<p>

										<select id="selSize" name="size" style="width:150px;" required>
											<option value="">Select Size</option>
											@foreach($productDetails->attributes as $sizes)
											<option value="{{ $productDetails->id }}-{{ $sizes->size }}">{{ $sizes->size }}</option>
											@endforeach
										</select>
									</p>

									<span id="getPrice">INR {{$productDetails->price}}</span>
									<label>Quantity:</label>
									<input type="text" value="1" />
									<button type="button" class="btn btn-fefault cart">
										<i class="fa fa-shopping-cart"></i>
										Add to cart
									</button>
								</span>
								<p><b>Availability:</b> In Stock</p>
								<p><b>Condition:</b> New</p>

								<a href=""><img src="{{asset('images/frontend_images/product-details/share.png')}}" class="share img-responsive"  alt="" /></a>
							</div><!--/product-information-->
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



				</div>
			</div>
		</div>
		</div>
	</section>










@endsection
