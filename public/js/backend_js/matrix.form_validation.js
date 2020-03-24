
$(document).ready(function(){


	$("#current_pwd").keyup(function(){
	var current_pwd = $("#current_pwd").val();
	$.ajax({
		type:'get',
		url:'/admin/check_pwd',
		data:{current_pwd:current_pwd},
		success:function(resp){
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


// Product Validation
$("#add_product").validate({
	rules:{
		category_id:{
			required:true
		},
		product_name:{
			required:true
		},
		product_code:{
			required:true
		},
		product_color:{
			required:true
		},
		price:{
			required:true,
			number:true
		},
		image:{
			required:true
		},

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

// Product Validation
$("#edit_product").validate({
	rules:{
		category_id:{
			required:true
		},
		product_name:{
			required:true
		},
		product_code:{
			required:true
		},
		product_color:{
			required:true
		},
		price:{
			required:true,
			number:true
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




	//$('input[type=checkbox],input[type=radio],input[type=file]').uniform();

	$('select').select2();

	// Form Validation
    $("#basic_validate").validate({
		rules:{
			required:{
				required:true
			},
			email:{
				required:true,
				email: true
			},
			date:{
				required:true,
				date: true
			},
			url:{
				required:true,
				url: true
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


	// Category Validation
$("#add_category").validate({
	rules:{
		category_name:{
			required:true
		},
		url:{
			required:true
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



	$("#number_validate").validate({
		rules:{
			min:{
				required: true,
				min:10
			},
			max:{
				required:true,
				max:24
			},
			number:{
				required:true,
				number:true
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

	$("#password_validate").validate({
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

	/*$('#del_cat').on('click',function(){

    if(confirm('Are You Sure You Want To Delete This Category')) {
			  return true;
		}

		  return false;

	});
*/

	// use sweet alert to delete products

	$(document).on('click','.deleteRecord',function(e){


        var id = $(this).attr('rel');
				//alert(id);
        var deleteFunction = $(this).attr('rel1');
				//alert(deleteFunction);

        swal({
					title: 'Are you sure?',
          text: "You won't be able to revert this!",
			  	icon: 'warning',

					buttons: {
	             cancel: {
													text: "Cancel",
													value: null,
													visible: true,
													className: "",
													closeModal: true,
            },
					  confirm: {
											    text: "Yes Delete it",
											    value: true,
											    visible: true,
											    className: "btn-danger",
											    closeModal: true
					  }
          },

        }).then((isConfirm) => {
               if (isConfirm){
                     window.location.href='/admin/'+deleteFunction+'/'+id;
               }

	  });


    });


   // add dynamic input fields

	 $(document).ready(function(){
    var maxField = 10; //Input fields increment limitation
    var addButton = $('.add_button'); //Add button selector
    var wrapper = $('.field_wrapper'); //Input field wrapper
    var fieldHTML = '<div class="controls field_wrapper" style="margin-left:-2px;"><input type="text" name="sku[]" placeholder="SKU" style="width:120px"/>&nbsp;<input type="text" name="size[]" placeholder="Size" style="width:120px"/>&nbsp;<input type="text" name="price[]" placeholder="Price" style="width:120px"/>&nbsp;<input type="text" name="stock[]" placeholder="Stock" style="width:120px"/><a href="javascript:void(0);" class="remove_button" title="Remove field">Remove</a></div>'; //New input field html 
    var x = 1; //Initial field counter is 1

    //Once add button is clicked
    $(addButton).click(function(){
        //Check maximum number of input fields
        if(x < maxField){
            x++; //Increment field counter
            $(wrapper).append(fieldHTML); //Add field html
        }
    });

    //Once remove button is clicked
    $(wrapper).on('click', '.remove_button', function(e){
        e.preventDefault();
        $(this).parent('div').remove(); //Remove field html
        x--; //Decrement field counter
    });
});



});// the end
