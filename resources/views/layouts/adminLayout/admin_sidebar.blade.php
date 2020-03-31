<?php $url = url()->current(); ?>
<!--sidebar-menu-->
<div id="sidebar"><a href="#" class="visible-phone"><i class="icon icon-home"></i> Dashboard</a>
  <ul>
    <li <?php if (preg_match("/dashboard/i", $url)){ ?> class="active" <?php } ?> ><a href="{{ url('/admin/dashboard') }}"><i class="icon icon-home"></i> <span>Dashboard</span></a> </li>
    <li class="submenu"> <a href="#"><i class="icon icon-info-sign"></i> <span>Categories</span> <span class="label label-important">2</span></a>
      <ul <?php if (preg_match("/categor/i", $url)){ ?> style="display: block;" <?php } ?>>
        <li <?php if (preg_match("/add_category/i", $url)){ ?> class="active" <?php } ?>><a href="{{ url('/admin/add_category') }}">create</a></li>
        <li <?php if (preg_match("/view_category/i", $url)){ ?> class="active" <?php } ?>><a href="{{url('/admin/view_category')}}">view</a></li>

      </ul>
    </li>

    <li class="submenu"> <a href="#"><i class="icon icon-info-sign"></i> <span>Products</span> <span class="label label-important">2</span></a>
      <ul <?php if (preg_match("/product/i", $url)){ ?> style="display: block;" <?php } ?>>
        <li <?php if (preg_match("/add_product/i", $url)){ ?> class="active" <?php } ?>><a href="{{ url('/admin/add_product') }}">create</a></li>
        <li <?php if (preg_match("/view_products/i", $url)){ ?> class="active" <?php } ?>><a href="{{url('/admin/view_products')}}">view</a></li>

      </ul>
    </li>

    <li class="submenu"> <a href="#"><i class="icon icon-info-sign"></i> <span>Coupons</span> <span class="label label-important">2</span></a>
      <ul <?php if (preg_match("/coupon/i", $url)){ ?> style="display: block;" <?php } ?>>
        <li <?php if (preg_match("/add_coupons/i", $url)){ ?> class="active" <?php } ?> ><a href="{{ url('/admin/add_coupons') }}">create</a></li>
        <li <?php if (preg_match("/view_coupons/i", $url)){ ?> class="active" <?php } ?>><a href="{{url('/admin/view_coupons')}}">view</a></li>

      </ul>
    </li>

    <li class="submenu"> <a href="#"><i class="icon icon-info-sign"></i> <span>Banners</span> <span class="label label-important">2</span></a>
      <ul <?php if (preg_match("/banner/i", $url)){ ?> style="display: block;" <?php } ?>>
        <li <?php if (preg_match("/add_banner/i", $url)){ ?> class="active" <?php } ?>><a href="{{ url('/admin/add_banner') }}">create</a></li>
        <li <?php if (preg_match("/view-banners/i", $url)){ ?> class="active" <?php } ?>><a href="{{url('/admin/view_banners')}}">view</a></li>

      </ul>
    </li>






  </ul>
</div>
<!--sidebar-menu-->
