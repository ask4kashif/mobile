Stripe.setPublishableKey('pk_test_C19gQj2HDIpqAhKeWjstolql');
	
	var $form=$('#checkout-form');
	
	$form.submit(function(event){
	
	$form.find('button').prop('disabled',true);	
	Stripe.card.createToken({
		number: $('#card-number').val(),
		cvc: $('#card.cvc').val(),
		exp_month: $('#card-expiry-month').val(),
		exp_year: $('#card-expiry-year').val(),
		name: $('#card-name').val()
	},stripeResponseHandler);
	return false;
});
function stripeResponseHandler(status,response){
	if(response.error){
		$('#charge-error').text(response.error.message);
		$form.find('button').prop('disabled',false);
	}else{
		var token=response.id;
		$form.append($('<input type="hidden" class="stripeToken" />').val(token));
		$form.get(0).submit();
	}
}

