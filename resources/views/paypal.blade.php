@extends('layouts/app')

@section('content')
<script src="https://www.paypal.com/sdk/js?client-id=AQOD85pTVwm9xpGCEMVkRY2WIr8ZjoXbUJYYzBbb2U0l8gy_h4eCykQmoIHDyFznNZhjlH3WRQjxpYtX"> // Replace YOUR_CLIENT_ID with your sandbox client ID
</script>
	<h1>paypal</h1>
    <div id="paypal-button-container"></div>
<!-- Add the checkout buttons, set up the order and approve the order -->
<script>
    paypal.Buttons({
      createOrder: function(data, actions) {
        return actions.order.create({
          purchase_units: [{
            amount: {
              value: '0.01'
            }
          }]
        });
      },
      onApprove: function(data, actions) {
        return actions.order.capture().then(function(details) {
          alert('Transaction completed by ' + details.payer.name.given_name);
        });
      }
    }).render('#paypal-button-container'); // Display payment options on your web page
  </script>    
@endsection