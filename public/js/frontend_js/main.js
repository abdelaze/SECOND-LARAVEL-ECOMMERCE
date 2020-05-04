/*price range*/

 $('#sl2').slider();

	var RGBChange = function() {
	  $('#RGB').css('background', 'rgb('+r.getValue()+','+g.getValue()+','+b.getValue()+')')
	};

/*scroll to top*/

$(document).ready(function(){
	$(function () {
		$.scrollUp({
	        scrollName: 'scrollUp', // Element ID
	        scrollDistance: 300, // Distance from top/bottom before showing element (px)
	        scrollFrom: 'top', // 'top' or 'bottom'
	        scrollSpeed: 300, // Speed back to top (ms)
	        easingType: 'linear', // Scroll to top easing (see http://easings.net/)
	        animation: 'fade', // Fade, slide, none
	        animationSpeed: 200, // Animation in speed (ms)
	        scrollTrigger: false, // Set a custom triggering element. Can be an HTML string or jQuery object
					//scrollTarget: false, // Set a custom target element for scrolling to the top
	        scrollText: '<i class="fa fa-angle-up"></i>', // Text for element, can contain HTML
	        scrollTitle: false, // Set a custom <a> title if required.
	        scrollImg: false, // Set true to use image
	        activeOverlay: false, // Set CSS color to display scrollUp active point, e.g '#00FFFF'
	        zIndex: 2147483647 // Z-Index for the overlay
		});
	});
});

// get price using ajax

$(document).ready(function(){
  $.ajaxSetup({
   headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });

    // alert('test');
     $("#selSize").change(function(){
      //  alert('test');
          var idsize = $(this).val();
        //  alert(idsize);
           if(idsize==""){
             return false;
           }
          $.ajax({

            type:'GET',
            url:"/get_product_price",
            data:{idsize:idsize},

            success:function(resp){
              var arr = resp.split('#');
      				$("#getPrice").html("INR "+arr[0]);
      		   	$("#price").val(arr[0]);
      				if(arr[1]==0){
      					$("#cartButton").hide();
      					$("#availability").text("Out Of Stock");
      				}else{
      					$("#cartButton").show();
      					$("#availability").text("In Stock");
      				}


            },error:function(){
              alert("Error zaza");
            }
          });

    });

});


$(document).ready(function(){
	$(function () {
		$.scrollUp({
	        scrollName: 'scrollUp', // Element ID
	        scrollDistance: 300, // Distance from top/bottom before showing element (px)
	        scrollFrom: 'top', // 'top' or 'bottom'
	        scrollSpeed: 300, // Speed back to top (ms)
	        easingType: 'linear', // Scroll to top easing (see http://easings.net/)
	        animation: 'fade', // Fade, slide, none
	        animationSpeed: 200, // Animation in speed (ms)
	        scrollTrigger: false, // Set a custom triggering element. Can be an HTML string or jQuery object
					//scrollTarget: false, // Set a custom target element for scrolling to the top
	        scrollText: '<i class="fa fa-angle-up"></i>', // Text for element, can contain HTML
	        scrollTitle: false, // Set a custom <a> title if required.
	        scrollImg: false, // Set true to use image
	        activeOverlay: false, // Set CSS color to display scrollUp active point, e.g '#00FFFF'
	        zIndex: 2147483647 // Z-Index for the overlay
		});
	});
});

// get price using ajax

$(document).ready(function(){


   $(".changeImage").click(function(){
		var image = $(this).attr('src');
		$(".mainImage").attr("src", image);

	});


});


// Instantiate EasyZoom instances
		var $easyzoom = $('.easyzoom').easyZoom();

		// Setup thumbnails example
		var api1 = $easyzoom.filter('.easyzoom--with-thumbnails').data('easyZoom');

		$('.thumbnails').on('click', 'a', function(e) {
			var $this = $(this);

			e.preventDefault();

			// Use EasyZoom's `swap` method
			api1.swap($this.data('standard'), $this.attr('href'));
		});

		// Setup toggles example
		var api2 = $easyzoom.filter('.easyzoom--with-toggle').data('easyZoom');

		$('.toggle').on('click', function() {
			var $this = $(this);

			if ($this.data("active") === true) {
				$this.text("Switch on").data("active", false);
				api2.teardown();
			} else {
				$this.text("Switch off").data("active", true);
				api2._init();
			}
});


// validate user register
$().ready(function(){
	// Validate Register form on keyup and submit
	$("#registerForm").validate({
		rules:{
			name:{
				required:true,
				minlength:2,
				accept: "[a-zA-Z]+"
			},
			password:{
				required:true,
				minlength:6
			},
			email:{
				required:true,
				email:true,
				remote:"/check_email"
			}
		},
		messages:{
			name:{
				required:"Please enter your Name",
				minlength: "Your Name must be atleast 2 characters long",
				accept: "Your Name must contain letters only"
			},
			password:{
				required:"Please provide your Password",
				minlength: "Your Password must be atleast 6 characters long"
			},
			email:{
				required: "Please enter your Email",
				email: "Please enter valid Email",
				remote: "<p style='color:red;'>Email already exists!</p>"
			}
		}
});

$("#loginForm").validate({
  rules:{

    password:{
      required:true,
    },
    email:{
      required:true,
      email:true,

    }
  },
  messages:{

    password:{
      required:"Please provide your Password",

    },
    email:{
      required: "Please enter your Email",
      email: "Please enter valid Email",

    }
  }
});

// Validate Register form on keyup and submit
	$("#accountForm").validate({
		rules:{
			name:{
				required:true,
				minlength:2,
				accept: "[a-zA-Z]+"
			},
			address:{
				required:true,
				minlength:6
			},
			city:{
				required:true,
				minlength:2
			},
			state:{
				required:true,
				minlength:2
			},
			country:{
				required:true
			}
		},
		messages:{
			name:{
				required:"Please enter your Name",
				minlength: "Your Name must be atleast 2 characters long",
				accept: "Your Name must contain letters only"
			},
			address:{
				required:"Please provide your Address",
				minlength: "Your Address must be atleast 10 characters long"
			},
			city:{
				required:"Please provide your City",
				minlength: "Your City must be atleast 2 characters long"
			},
			state:{
				required:"Please provide your State",
				minlength: "Your State must be atleast 2 characters long"
			},
			country:{
				required:"Please select your Country"
			},
		}
});


// Check Current User Password
	$("#current_pwd").keyup(function(){
		var current_pwd = $(this).val();
		$.ajax({
			headers: {
			        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			    },
			type:'post',
			url:'/check_user_pwd',
			data:{current_pwd:current_pwd},
			success:function(resp){
				/*alert(resp);*/
				if(resp=="false"){
					$("#chkPwd").html("<font color='red'>Current Password is incorrect</font>");
				}else if(resp=="true"){
					$("#chkPwd").html("<font color='green'>Current Password is correct</font>");
				}
			},error:function(){
				alert("Error");
			}
		});
	});


  $("#passwordForm").validate({
    rules:{
      current_pwd:{
        required: true,
        minlength:6,
        maxlength:20
      },
      new_pwd:{
        required: true,
        minlength:6,
        maxlength:20
      },
      confirm_pwd:{
        required:true,
        minlength:6,
        maxlength:20,
        equalTo:"#new_pwd"
      }
    },
    errorClass: "help-inline",
    errorElement: "span",
    highlight:function(element, errorClass, validClass) {
      $(element).parents('.control-group').addClass('error');
    },
    unhighlight: function(element, errorClass, validClass) {
      $(element).parents('.control-group').removeClass('error');
      $(element).parents('.control-group').addClass('success');
    }
});

$('#myPassword').passtrength({
      minChars: 4,
      passwordToggle: true,
      tooltip: true,
      eyeImg : "/images/frontend_images/eye.svg"
});

$('#copyAddress').on('click',function(){
    // alert('test');
    if(this.checked) {
       $('#shipping_name').val($('#billing_name').val());
       $('#shipping_address').val($('#billing_address').val());
       $('#shipping_city').val($('#billing_city').val());
       $('#shipping_state').val($('#billing_state').val());
       $('#shipping_country').val($('#billing_country').val());
       $('#shipping_pincode').val($('#billing_pincode').val());
       $('#shipping_mobile').val($('#billing_mobile').val());
    }else {
      $('#shipping_name').val('');
      $('#shipping_address').val('');
      $('#shipping_city').val('');
      $('#shipping_state').val('');
      $('#shipping_country').val('');
      $('#shipping_pincode').val('');
      $('#shipping_mobile').val('');
    }
});
$('#Paypal').is(':checked')
});

// update cart Quantity

$(document).ready(function(){

// $('#cart_quantity_up').on('click',function(){
//
//      var cartID = $('#cart_id').val();
//      var quantity = 1//$('.cart_quantity_input').val();
//      //alert($quantity);
//      $.ajax({
//            url: '/cart/update_quantity',
//            method:"POST",
//            dataType:"json",
//            data : {
//              'cartID'   : cartID ,
//              'quantity' : quantity
//            },
//            success:function(resp)
//            {
//
//
//                       if(resp.quantity) {
//
//                         $('.cart_quantity_input').val(resp.quantity);
//
//                     }
//
//                     if(resp.error) {
//                       $error = '<div class="alert alert-danger">' + resp.error + '</div>';
//
//                       $('#cart_error').html($error);
//
//                       setTimeout(function(){
//
//                               $('#cart_error').css('display','none');
//
//                        },3000)
//                 }
//
//              $("#cart_data").load(window.location + " #cart_data");
//
//           }
//
//
//    });
//
//    });// end add button
//
//    $('#cart_quantity_down').on('click',function(){
//
//         var cartID = $('#cart_id').val();
//         var quantity = -1;//$('.cart_quantity_input').val();
//         //alert($quantity);
//         $.ajax({
//               url: '/cart/update_quantity',
//               method:"POST",
//               dataType:"json",
//               data : {
//                 'cartID'   : cartID ,
//                 'quantity' : quantity
//               },
//               success:function(resp)
//               {
//
//
//
//                            $('.cart_quantity_input').val(resp.quantity);
//                              //location.reload(true);
//                            // if(resp.quantity <=1) {
//                            //   $(this).css('display','none');
//                            // }
//                            // else {
//                            //     $(this).css('display','block');
//                            // }
//                         //    var table = $('#cart_data').DataTable( {
//                         //     ajax: "data.json"
//                         // } );
//                       $("#myTable").load(window.location + " #myTable");
//                       //$('#myTable').load();
//                       //  table.ajax.reload();
//
//
//              }
//
//
//       }); // end minus button
//
//
// });



});

// show message if not select payment method
function selectPaymentMethod() {
   if($('#Paypal').is(':checked') || $('#COD').is(':checked')) {

   }else {
     alert('please select payment method!');
     return false;
   }
}



// use data table
