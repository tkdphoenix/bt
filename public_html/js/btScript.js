// event listener for payment method
$(".radioPmtMethod").on('click', function(){
	if($(this).val() === "false"){
		$('.paymentMethodDetails').hide();
	} else {
		$('.paymentMethodDetails').show();
	}
});

// event listener for billing address
$(".radioBillingAddr").on('click', function(){
	var radioBillingAddr = $(this);
	if($(this).val() === "false"){
		$('.billingAddressDetails').hide();
	} else {
		$('.billingAddressDetails').show();
	}
});
// $('input[name=withPmtMethodRadio]:checked', '#newCustForm').val()
// $('input[name=withBillingAddressRadio]:checked', '#newCustForm').val()
