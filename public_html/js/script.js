function calculateTotal(amt, shipping, tax){
	amt = parseFloat(amt);
	shipping = parseFloat(shipping);
	tax = parseFloat(tax);
	var total = amt + shipping + tax;
	if(typeof(total) === 'number'){ return total.toFixed(2); } else { console.error('NaN'); }
}

function runTotal(){
		var amt = $('#amt').val();
		var shippingamt = $('#shippingamt').val();
		var taxamt = $('#taxamt').val();
		var newTotal = calculateTotal(amt, shippingamt, taxamt);
		$('#totalamt').val(newTotal);
		return;
}

$(document).ready(function(){
	/* this block of code was only here when I had individual inputs for each value
		runTotal();
		$('#amt, #shippingamt, #taxamt').on('change', function(){
			runTotal();
		});
	*/
	$(".method").on('click', function(){
		var methodName = $(this).text();
		var origText = "NO API SELECTED";
		$(this).toggleClass('selected');
		if($(this).hasClass('selected')){
			console.log('selected');
			$("#apiName").text(methodName);
		} else {
			console.log('NOT selected');
			$("#apiName").text(origText);
		}	
	});

*/
$(".method").on('click', function(){
	var methodName = $(this).text();
	var origText = "NO API SELECTED";
	$(this).toggleClass('selected');
	if($(this).hasClass('selected')){
		console.log('selected');
		$("#apiName").text(methodName);
	} else {
		console.log('NOT selected');
		$("#apiName").text(origText);
	}	
});

// @TODO create a method to capture click of a specific API operation and store a value 
// so that back end knows which method to run
$(".leftNav .well a").on('click', function(){
	console.info($this.id);
});
}); // end document.ready()