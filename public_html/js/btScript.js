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

function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+d.toUTCString();
    document.cookie = cname + "=" + cvalue + "; " + expires;
}