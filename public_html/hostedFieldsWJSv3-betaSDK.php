<?php
	defined("DS")? null : require_once(realpath(dirname(__FILE__) . DIRECTORY_SEPARATOR . "..") . DIRECTORY_SEPARATOR . "inc" . DIRECTORY_SEPARATOR . "initialize.php");

	require_once(LIB_PATH . DS . "inc" . DS . "common.inc.php");
	require_once(LIB_PATH . DS . "btVars.php");

	$clientToken = Braintree_ClientToken::generate();

	function showForm($errorsArr=[]){
		if(isset($errorsArr)){
			foreach($errorsArr as $errMsg){
				echo "<p class='alert alert-danger'>". $errMsg ."</p>";
			}
		}
	?>
		<div class="card-form">
		  <div class="card-form__inner cf">
		    <div class="card-form__element" data-input-text="Credit Card Number">
		      <ul class="card-form__layers">
		        <li class="card-form__layer">
		          <form id="hostedCheckoutForm" action="?" method="post" >
		            <div id="cc-num" class="card-form__input card-form__hosted-field" /></form>
		        </li>
		      </ul>
		    </div>
		    <div class="card-form__element half" data-input-text="CVV">
		      <ul class="card-form__layers">
		        <li class="card-form__layer">
		          <form action="">
		            <div id="cc-cvv" class="card-form__input card-form__hosted-field"/>
		          </form>
		        </li>
		      </ul>
		    </div>
		    <div class="card-form__element half" data-input-text="MM/YY">
		      <ul class="card-form__layers">
		        <li class="card-form__layer">
		          <form action="">
		            <div id="cc-expiration-date" class="card-form__input card-form__hosted-field" />
		          </form>
		        </li>
		      </ul>
		    </div>
		    <input type="hidden" name="payment-method-nonce">
		    <button disabled value="submit" id="submit" class="btn greenBtn"><div>Pay</div></button>
		  </div>
		</div>

				<!-- <form id="hostedCheckoutForm" class="form-horizontal" method="post" action="<?php echo htmlspecialchars("?"); ?>">
				<!-- 	<div id="error-message"></div>
					<div data-input-text="card-number">Card Number</label>
					<div id="card-number" class="hosted-field" tabindex="10"></div>
					<label for="cvv">CVV</label>
					<div id="cvv" class="hosted-field" tabindex="15"></div>
					<label for="zip">Zip Code</label>
					<div id="zip" tabindex="20"></div>
					<label for="expiration-date">Expiration Date</label>
					<div id="expiration-date" class="hosted-field" tabindex="25"></div>
					<input id="amt" name="amt" type="hidden" value="10.00" />
					<input type="hidden" name="payment-method-nonce">
					<input class="btn greenBtn" name="btnSubmit" type="submit" value="Pay $10" tabindex="30" disabled />
				</form> -->
	<?php
	} // END showForm()

	// test if the nonce has been posted
	if(isset($_POST['payment-method-nonce'])){
		$nonce = strip_tags($_POST['payment-method-nonce']);
		$amt = strip_tags($_POST['amt']);
		// echo "nonce = ". $nonce ."\r\n";
		// echo "amt = ". $amt ."\r\n";

		try{
			$result = Braintree_Transaction::sale(
				array(
					'amount' => $amt,
					'paymentMethodNonce' => $nonce,
					'options' => array(
						'submitForSettlement' => false
				  	)
				)
			);
			if(!$result->success){
				foreach($result->errors->deepAll() as $error){
					file_put_contents($pathToBTErrorLog, timeNow() . " MST - createCustomer.php page\r\n" . $error->code .": ". $error->message, FILE_APPEND);
					throw new Exception($error->message, $error->code);
					var_dump($error);
				}
				
			}
		} catch (Exception $e){
			echo "<p class='error'>This payment could not be processed. ". $e->getMessage() ."</p";
		}

		if($result->success){
			$txn = $result->transaction;
			showBTHeader("Hosted Fields", "Hosted Fields Response");
			showBTLeftNav();
?>
			<div class="col-md-7">
				<div class="row">
					<div class="col-md-12">
<?php
			echo "Transaction detaiils: <br>";
			echo "id = ". $txn->id ."<br>";
			echo "status = ". $txn->status ."<br>";
			echo "type = ". $txn->type ."<br>";
			echo "amount = ". $txn->amount ."<br>";
			// echo "merchantAccountId = ". $txn->merchantAccountId ."<br>";
			// echo "createdAt Date = ". $txn->createdAt->date ." ". $txn->createdAt->timezone ."<br>";
			// echo "updatedAt Date = ". $txn->updatedAt->date ." ". $txn->updatedAt->timezone ."<br>";
			// echo "customer Id = ". $txn->customer['id'] ."<br>";
			// echo "customer firstName = ". $txn->customer['firstName'] ."<br>";
			// echo "customer lastName = ". $txn->customer['lastName'] ."<br>";
			// echo "customer company = ". $txn->customer['company'] ."<br>";
			// echo "customer email = ". $txn->customer['email'] ."<br>";
			// echo "customer phone = ". $txn->customer['phone'] ."<br>";
			// echo "customer fax = ". $txn->customer['fax'] ."<br>";
			// echo "billing Id = ". $txn->billing['id'] ."<br>";
			// echo "billing firstName = ". $txn->billing['firstName'] ."<br>";
			// echo "billing lastName = ". $txn->billing['lastName'] ."<br>";
			// echo "billing company = ". $txn->billing['company'] ."<br>";
			// echo "billing streetAddress = ". $txn->billing['streetAddress'] ."<br>";
			// echo "billing extendedAddress = ". $txn->billing['extendedAddress'] ."<br>";
			// echo "billing locality = ". $txn->billing['locality'] ."<br>";
			// echo "billing region = ". $txn->billing['region'] ."<br>";
			// echo "billing postalCode = ". $txn->billing['postalCode'] ."<br>";
			// echo "billing countryName = ". $txn->billing['countryName'] ."<br>";
			// echo "billing countryCodeAlpha2 = ". $txn->billing['countryCodeAlpha2'] ."<br>";
			// echo "billing countryCodeAlpha3 = ". $txn->billing['countryCodeAlpha3'] ."<br>";
			// echo "billing countryCodeNumeric = ". $txn->billing['countryCodeNumeric'] ."<br>";
			// echo "refundId = ". $txn->refundId ."<br>";
			// for($i=0, $ii=$txn->refundIds.count(); $i<$ii; $i++){
			// 	echo "refundIds$i = ". $txn->refundIds[$i] ."<br>";
			// }
			// echo "refundedTransactionId = ". $txn->refundedTransactionId ."<br>";
			// for($i=0, $ii=$txn->partialSettlementTransactionIds.count(); $i<$ii; $i++){
			// 	echo "partialSettlementTransactionIds$i = ". $txn->partialSettlementTransactionIds[$i] ."<br>";
			// }
			// echo "authorizedTransactionId = ". $txn->authorizedTransactionId ."<br>";
			// echo "settlementBatchId = ". $txn->settlementBatchId ."<br>";
			// echo "shipping ID = ". $txn->shipping['id'] ."<br>";
			// echo "shipping firstName = ". $txn->shipping['firstName'] ."<br>";
			// echo "shipping lastName = ". $txn->shipping['lastName'] ."<br>";
			// echo "shipping company = ". $txn->shipping['company'] ."<br>";
			// echo "shipping streetAddress = ". $txn->shipping['streetAddress'] ."<br>";
			// echo "shipping extendedAddress = ". $txn->shipping['extendedAddress'] ."<br>";
			// echo "shipping locality = ". $txn->shipping['locality'] ."<br>";
			// echo "shipping region = ". $txn->shipping['region'] ."<br>";
			// echo "shipping postalCode = ". $txn->shipping['postalCode'] ."<br>";
			// echo "shipping countryName = ". $txn->shipping['countryName'] ."<br>";
			// echo "shipping countryCodeAlpha2 = ". $txn->shipping['countryCodeAlpha2'] ."<br>";
			// echo "shipping countryCodeAlpha3 = ". $txn->shipping['countryCodeAlpha3'] ."<br>";
			// echo "shipping countryCodeNumeric = ". $txn->shipping['countryCodeNumeric'] ."<br>";
			// echo "customFields = ". $txn->customFields ."<br>";
			// echo "avsErrorResponseCode = ". $txn->avsErrorResponseCode ."<br>";
			// echo "avsPostalCodeResponseCode = ". $txn->avsPostalCodeResponseCode ."<br>";
			// echo "avsStreetAddressResponseCode = ". $txn->avsStreetAddressResponseCode ."<br>";
			// echo "cvvResponseCode = ". $txn->cvvResponseCode ."<br>";
			// echo "gatewayRejectionReason = ". $txn->gatewayRejectionReason ."<br>";
			// echo "processorAuthorizationCode = ". $txn->processorAuthorizationCode ."<br>";
			// echo "processorResponseCode = ". $txn->processorResponseCode ."<br>";
			// echo "processorResponseText = ". $txn->processorResponseText ."<br>";
			// echo "additionalProcessorResponse = ". $txn->additionalProcessorResponse ."<br>";
			// echo "voiceReferralNumber = ". $txn->voiceReferralNumber ."<br>";
			// echo "purchaseOrderNumber = ". $txn->purchaseOrderNumber ."<br>";
			// echo "taxAmount = ". $txn->taxAmount ."<br>";
			// echo "taxExempt = ". $txn->taxExempt ."<br>";
			// echo "creditCard token = ". $txn->creditCard['token'] ."<br>";
			// echo "creditCard bin = ". $txn->creditCard['bin'] ."<br>";
			// echo "creditCard last4 = ". $txn->creditCard['last4'] ."<br>";
			// echo "creditCard cardType = ". $txn->creditCard['cardType'] ."<br>";
			// echo "creditCard expirationMonth = ". $txn->creditCard['expirationMonth'] ."<br>";
			// echo "creditCard expirationYear = ". $txn->creditCard['expirationYear'] ."<br>";
			// echo "creditCard customerLocation = ". $txn->creditCard['customerLocation'] ."<br>";
			// echo "creditCard cardholderName = ". $txn->creditCard['cardholderName'] ."<br>";
			// echo "creditCard imageUrl = ". $txn->creditCard['imageUrl'] ."<br>";
			// echo "creditCard prepaid = ". $txn->creditCard['prepaid'] ."<br>";
			// echo "creditCard healthcare = ". $txn->creditCard['healthcare'] ."<br>";
			// echo "creditCard debit = ". $txn->creditCard['debit'] ."<br>";
			// echo "creditCard durbinRegulated = ". $txn->creditCard['durbinRegulated'] ."<br>";
			// echo "creditCard commercial = ". $txn->creditCard['commercial'] ."<br>";
			// echo "creditCard payroll = ". $txn->creditCard['payroll'] ."<br>";
			// echo "creditCard issuingBank = ". $txn->creditCard['issuingBank'] ."<br>";
			// echo "creditCard countryOfIssuance = ". $txn->creditCard['countryOfIssuance'] ."<br>";
			// echo "creditCard productId = ". $txn->creditCard['productId'] ."<br>";
			// echo "creditCard uniqueNumberIdentifier = ". $txn->creditCard['uniqueNumberIdentifier'] ."<br>";
			// echo "creditCard venmoSdk = ". $txn->creditCard['venmoSdk'] ."<br>";
			
			// @TODO may not work well - need to experiment to make sure this is right
			// echo "transaction statusDetails timestamp= ". $txn->statusDetails['timestamp']->date ." ". $txn->statusDetails['timstamp']->timezone ."<br>"; 
			// echo "transaction statusDetails status= ". $txn->statusDetails->status ."<br>"; 
			// echo "transaction statusDetails amount= ". $txn->statusDetails->amount ."<br>"; 
			// echo "transaction statusDetails user= ". $txn->statusDetails->user ."<br>"; 
			// echo "transaction statusDetails transactionSource= ". $txn->statusDetails->transactionSource ."<br>";
			// echo "planId = ". $txn->planId ."<br>";
			// echo "subscriptionId = ". $txn->subscriptionId ."<br>";
			// echo "subscriptionId billingPeriodEndDate = ". $txn->subscriptionId['billingPeriodEndDate'] ."<br>";
			// echo "subscriptionId billingPeriodStartDate = ". $txn->subscriptionId['billingPeriodStartDate'] ."<br>";
			// for($i=0, $ii=$txn->addOns.count(); $i<$ii; $i++){
			// 	echo "addOns$i = ". $txn->addOns[$i] ."<br>";
			// }
			// for($i=0, $ii=$txn->discounts.count(); $i<$ii; $i++){
			// 	echo "discounts$i = ". $txn->discounts[$i] ."<br>";
			// }
			// echo "Transaction descriptor name: ". $txn->descriptor['name'] ."<br>";
			// echo "Transaction descriptor phone: ". $txn->descriptor['phone'] ."<br>";
			// echo "Transaction descriptor url: ". $txn->descriptor['url'] ."<br>";
			// echo "Transaction recurring: "; echo ($txn->recurring)? 'true': 'false';
			// echo "Transaction channel: ". $txn->channel ."<br>";
			// echo "Transaction serviceFeeAmount: ". $txn->serviceFeeAmount ."<br>";
			// echo "Transaction escrowStatus: ". $txn->escrowStatus ."<br>";
			// echo "Transaction escrowStatus: ". $txn->escrowStatus ."<br>";

			// @TODO not done
		} // END if($result->success)
	} else { // END if(isset($_POST['payment_method_nonce']))
	showBTHeader("Hosted Fields", "Hosted Fields");
	showBTLeftNav();
?>
		<div class="col-md-7">
			<div class="row">
				<div class="col-md-12">
					<h3>Pay by PayPal</h3>
					<div id="paypalContainer"></div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<h3>Pay by Credit Card</h3>		
<?php
	showForm();
?>
				</div>
			</div>
		</div>
	
		<!-- Load the required client component. -->
		<script src="https://js.braintreegateway.com/web/3.0.0/js/client.js"></script>

		<!-- Load Hosted Fields component. -->
		<script src="https://js.braintreegateway.com/web/3.0.0/js/hosted-fields.js"></script>

	<script>
	var submit = document.querySelector('#submit');
	var form = document.querySelector('#hostedCheckoutForm');
		braintree.client.create({
		authorization: 'sandbox_g42y39zw_348pk9cgf3bgyw2b'
		}, function (err, clientInstance) {
		braintree.hostedFields.create({
			client: clientInstance,
			fields: {
				number: {
					selector: '#cc-num',
					placeholder: 'Credit Card Number'
				},
				cvv: {
					selector: '#cc-cvv',
					placeholder: 'CVV'
				},
				expirationDate: {
					selector: '#cc-expiration-date',
					placeholder: 'MM/YY'
				}
			},
			styles: {
				input: {
					'font-size': '16px',
					'-webkit-font-smoothing': 'antialiased'
				}
			}
		}, function (err, hostedFieldsInstance) {
	    
			hostedFieldsInstance.on('validityChange', function (event) {
				var allValid = true;
				var field, key;
		      
				for (key in event.fields) {
					if (event.fields[key].isValid === false) {
						allValid = false;
						break;
					}
				}
		      
				if (allValid) {
					submit.removeAttribute('disabled');
				} else {
					submit.setAttribute('disabled', 'disabled');
				}
	    	});
	    
		    submit.addEventListener('click', function () {
				if (err) {
					console.error(err);
					return;
				}

				// This is where you would submit payload.nonce to your server
				console.log('Submit your nonce to your server here!');
				console.log("hosted fields instance: " + hostedFieldsInstance);
				document.querySelector('input[name="payment-method-nonce"]').value = hostedFieldsInstance.nonce;
				form.submit();
		    });
		});
	});









	// var form = document.querySelector('#hostedCheckoutForm');
	// var submit = document.querySelector('input[type="submit"]');
	// var clientToken = "<?=$clientToken?>";

	// braintree.client.create({
	//     authorization: clientToken
	// }, function (clientErr, clientInstance) {
	    // if(clientErr) {
	    //     // Handle error in client creation
	    //     return;
	    // }

	    // braintree.hostedFields.create({
	    //     client: clientInstance,
	    //     styles: {
	    //         'input': {
	    //             'font-size': '14pt'
	    //         },
	    //         'input.invalid': {
	    //             'color': 'red'
	    //         },
	    //         'input.valid': {
	    //             'color': 'green'
	    //         }
	    //     },
	    //     fields: {
	    //         number: {
	    //             selector: '#card-number',
	    //             placeholder: '41111 1111 1111 1111'
	    //         },
	    //         cvv: {
	    //             selector: '#cvv',
	    //             placeholder: '123'
	    //         },
	    //         expirationDate: {
	    //             selector: '#expiration-date',
	    //             placeholder: '10 / 2019'
	    //         }
	    //     }
	    // }, function (hostedFieldsErr, hostedFieldsInstance) {
	    //     if (hostedFieldsErr) {
	    //         // Handle error in Hosted Fields creation
	    //         return;
	    //     }

	    //     submit.removeAttribute('disabled');

	    //     form.addEventListener('submit', function(event){
	    //         event.preventDefault();

	    //         hostedFieldsInstance.tokenize(function(tokenizeErr, payload){
 //                    if(tokenizeErr){
 //                        // Handle error in Hosted Fields Tokenization
 //                        return;
 //                    }

 //                    // Put 'payload.nonce' into the 'payment-method-nonce' input, and then
 //                    // submit the form. Alternatively, you could send the nonce to your server
 //                    // with AJAX.
 //                    document.querySelector('input[name="payment-method-nonce"]').value = payload.nonce;
 //                    form.submit();
	//             });
	//         }, false);
	//     });
	// });

//	braintree.setup(
//		"<?//=$clientToken?>//",
//		"custom",
//		{
//			id: 'hostedCheckoutForm',
//			paypal: {
//				container: "paypalContainer",
//				singleUse: true,
//				amount: $("#amt").val(),
//				currency: "USD",
//				locale: "en_us",
//				enableShippingAddress: true
//			},
//			hostedFields: {
//				number: {
//					selector: "#cardNum",
//					placeholder: "Card Number"
//				},
//				cvv: {
//					selector: "#cvv",
//					placeholder: "CVV"
//				},
//				postalCode: {
//					selector: "#zip",
//					placeholder: "Postal Code"
//				},
//				expirationDate: {
//					selector: "#expDate",
//					placeholder: "Expiration Date"
//				}
//			}
//		});
	</script>
<?php
showBTFooter();
}
?>