@extends('layouts.frontlayout.front_design')
<?php use App\Order; ?>
@section('style')
<style>

/**
 * The CSS shown here will not be introduced in the Quickstart guide, but shows
 * how you can use CSS to style your Element's container.
 */
.StripeElement {
  box-sizing: border-box;

  height: 40px;
  width: 800px;
  padding: 10px 12px;
  margin: 20px;
  border: 1px solid transparent;
  border-radius: 4px;
  background-color: white;

  box-shadow: 0 1px 3px 0 #e6ebf1;
  -webkit-transition: box-shadow 150ms ease;
  transition: box-shadow 150ms ease;
}



.StripeElement--focus {
  box-shadow: 0 1px 3px 0 #cfd7df;
}

.StripeElement--invalid {
  border-color: #fa755a;
}

.StripeElement--webkit-autofill {
  background-color: #fefde5 !important;
}
</style>

@endsection
@section('content')
        <section id="cart_items">
        	<div class="container">
        		<div class="breadcrumbs">
        			<ol class="breadcrumb">
        			  <li><a href="#">Home</a></li>
        			  <li class="active">Thanks</li>
        			</ol>
        		</div>
        	</div>
        </section>

        <section id="do_action">
        	<div class="container">
        		<div class="heading" align="center">
        			<h3>YOUR Paypal ORDER HAS BEEN PLACED</h3>
        			<p>Your order number is {{ Session::get('order_id') }} and total payable about is $ {{ Session::get('grand_total') }}</p>
              <p>please make payment by clicking on  below payment button </p>
                  <!-- <form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
                          <input type="hidden" name="cmd" value="_s-xclick">
                          <input type="hidden" name="business" value="abdelazem1581996@gmail.com">
                          <input type="hidden" name="item_name" value="{{ Session::get('order_id') }}">
                          <input type="hidden" name="item_number" value="{{ Session::get('order_id') }}">
                          <input type="hidden" name="amount" value="{{ Session::get('grand_total') }}">
                          <input type="hidden" name="currency_code" value="USD">
                          <input type="image" src="https://www.paypalobjects.com/webstatic/en_US/i/btn/png/btn_buynow_107x26.png" alt="Buy Now">
                          <img alt="" src="https://paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
                </form> -->
                <?php
              			$orderDetails = Order::getOrderDetails(Session::get('order_id'));
              			$orderDetails = json_decode(json_encode($orderDetails));
              			/*echo "<pre>"; print_r($orderDetails); die;*/
              			$nameArr = explode(' ',$orderDetails->name);
              			$getCountryCode = Order::getCountryCode($orderDetails->country);
		        	?>
                <!-- <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
            				<input type="hidden" name="cmd" value="_xclick">
            				<input type="hidden" name="business" value="sb-4wjab572854@business.example.com">
            				<input type="hidden" name="item_name" value="{{ Session::get('order_id') }}">
            				<input type="hidden" name="currency_code" value="USD">
            				<input type="hidden" name="amount" value="{{ Session::get('grand_total') }}">
                    <input type="hidden" name="first_name" value="{{ $nameArr[0] }}">
            				<input type="hidden" name="last_name" value="{{ $nameArr[1] }}">
            				<input type="hidden" name="address1" value="{{ $orderDetails->address }}">
            				<input type="hidden" name="address2" value="">
            				<input type="hidden" name="city" value="{{ $orderDetails->city }}">
            				<input type="hidden" name="state" value="{{ $orderDetails->state }}">
            				<input type="hidden" name="zip" value="{{ $orderDetails->pincode }}">
            				<input type="hidden" name="email" value="{{ $orderDetails->user_email }}">
            				<input type="hidden" name="country" value="{{ $getCountryCode->country_code }}">
                    <input type="hidden" name="return" value="{{ url('paypal/thanks') }}">
			            	<input type="hidden" name="cancel_return" value="{{ url('paypal/cancel') }}">
            				<input type="image"
            				    src="https://www.paypalobjects.com/webstatic/en_US/i/btn/png/btn_paynow_107x26.png" alt="Pay Now">
            				  <img alt="" src="https://paypalobjects.com/en_US/i/scr/pixel.gif"
            				    width="1" height="1">
			      </form> -->


           <!-- using paypal server integration  -->

             <div id="paypal-button"></div>






           <!-- end using paypal server integration  -->

     <br><br>
          <!-- using stripe payment -->
            <form action="{{url('charge')}}" method="post" id="payment-form">
              {{ csrf_field() }}
              <input type="hidden" name="item_name" value="{{ Session::get('order_id') }}">

              <input type="hidden" name="amount" value="{{ Session::get('grand_total') }}">
              <input type="hidden" name="first_name" value="{{ $nameArr[0] }}">
              <input type="hidden" name="last_name" value="{{ $nameArr[1] }}">
              <input type="hidden" name="address1" value="{{ $orderDetails->address }}">
              <input type="hidden" name="address2" value="">
              <input type="hidden" name="city" value="{{ $orderDetails->city }}">
              <input type="hidden" name="state" value="{{ $orderDetails->state }}">
              <input type="hidden" name="zip" value="{{ $orderDetails->pincode }}">
              <input type="hidden" name="email" value="{{ $orderDetails->user_email }}">
              <input type="hidden" name="country" value="{{ $getCountryCode->country_code }}">
                 <div class="form-group">
                    <label for="card-element">
                      Credit or debit card
                    </label>
                    <div id="card-element">
                      <!-- A Stripe Element will be inserted here. -->
                    </div>

                    <!-- Used to display form errors. -->
                    <div id="card-errors" role="alert"></div>
                  </div>

                  <button class="btn btn-info">Submit Payment</button>
      </form>

     <!-- end using stripe payment -->


      <!-- my work  -->
          </div>
        	</div>
        </section>

@endsection

<?php
Session::forget('grand_total');
Session::forget('order_id');
?>

@section('script')
  <!-- start payment using stripe  -->
  <script src="https://js.stripe.com/v3/"></script>
  <script>
      window.onload = function(){

                      // Create a Stripe client.
              var stripe = Stripe('pk_test_GsJoxEapLeLTNotGkyhHBppG');

              // Create an instance of Elements.
              var elements = stripe.elements();

              // Custom styling can be passed to options when creating an Element.
              // (Note that this demo uses a wider set of styles than the guide below.)
              var style = {
              base: {
               color: '#32325d',
               fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
               fontSmoothing: 'antialiased',
               fontSize: '16px',
               '::placeholder': {
                 color: '#aab7c4'
               }
              },
              invalid: {
               color: '#fa755a',
               iconColor: '#fa755a'
              }
              };

              // Create an instance of the card Element.
              var card = elements.create('card', {style: style});

              // Add an instance of the card Element into the `card-element` <div>.
              card.mount('#card-element');

                            // Handle real-time validation errors from the card Element.
              card.addEventListener('change', function(event) {
                var displayError = document.getElementById('card-errors');
                if (event.error) {
                  displayError.textContent = event.error.message;
                } else {
                  displayError.textContent = '';
                }
              });

              // Handle form submission.
              var form = document.getElementById('payment-form');
              form.addEventListener('submit', function(event) {
                event.preventDefault();

                stripe.createToken(card).then(function(result) {
                  if (result.error) {
                    // Inform the user if there was an error.
                    var errorElement = document.getElementById('card-errors');
                    errorElement.textContent = result.error.message;
                  } else {
                    // Send the token to your server.
                    stripeTokenHandler(result.token);
                  }
                });
              });

              // Submit the form with the token ID.
              function stripeTokenHandler(token) {
                // Insert the token ID into the form so it gets submitted to the server
                var form = document.getElementById('payment-form');
                var hiddenInput = document.createElement('input');
                hiddenInput.setAttribute('type', 'hidden');
                hiddenInput.setAttribute('name', 'stripeToken');
                hiddenInput.setAttribute('value', token.id);
                form.appendChild(hiddenInput);

                // Submit the form
                form.submit();
              }


      } //end function
  </script>


  <!-- start payment using paypal  -->
  <script src="https://www.paypalobjects.com/api/checkout.js"></script>
  <!-- <script src="https://www.paypal.com/sdk/js?client-id=sb"></script>
  <script>paypal.Buttons().render('body');</script> -->

  <script>
    paypal.Button.render({
      env: 'sandbox', // Or 'production'
      style: {
         size: 'large',
         color: 'gold',
         shape: 'pill',
       },
      // Set up the payment:
      // 1. Add a payment callback
      payment: function(data, actions) {
        // 2. Make a request to your server
        return actions.request.post('/api/create-payment/')
          .then(function(res) {
            // 3. Return res.id from the response
            return res.id;
          });
      },
      // Execute the payment:
      // 1. Add an onAuthorize callback
      onAuthorize: function(data, actions) {
        // 2. Make a request to your server
        return actions.request.post('/api/execute-payment/', {
          paymentID: data.paymentID,
          payerID:   data.payerID
        })
          .then(function(res) {
             console.log(res);
             alert('Payment Went Through!!');
            // 3. Show the buyer a confirmation message.
          });
      }
    }, '#paypal-button');
  </script>

@endsection
