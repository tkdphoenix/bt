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
				<form id="hostedCheckoutForm" class="form-horizontal" method="post" action="<?php echo htmlspecialchars("?"); ?>">
					<label for="cardNum">Card Number</label>
					<div id="cardNum" aria-label="Card Number" tabindex="10"></div>
					<label for="cvv">CVV</label>
					<div id="cvv" aria-label="CVV" type="password" tabindex="15"></div>
					<label for="zip">Zip Code</label>
					<div id="zip" aria-label="Zip Code" tabindex="20"></div>
					<label for="expDate">Expiration Date</label>
					<div id="expDate" aria-label="Expiration Date" tabindex="25"></div>
					<input id="amt" name="amt" type="hidden" value="10.00">
					<input class="btn greenBtn" name="submit" type="submit" aria-label="Pay $10 button" value="Pay $10" tabindex="30">
				</form>
	<?php
	} // END showForm()

	// test if the nonce has been posted
	if(isset($_POST['payment_method_nonce'])){
		$nonce = strip_tags($_POST['payment_method_nonce']);
		$amt = strip_tags($_POST['amt']);
		// echo "nonce = ". $nonce ."\r\n";
		// echo "amt = ". $amt ."\r\n";

		try{
			$result = Braintree_Transaction::sale(
				array(
					'amount' => $amt,
					'paymentMethodNonce' => $nonce,
					'options' => array(
						'submitForSettlement' => true,
						'storeInVaultOnSuccess' => true // store in vault
				  	)
				)
			);
			if(!$result->success){
				foreach($result->errors->deepAll() as $error){
					file_put_contents($pathToBTErrorLog, "\r\n". timeNow() . " MST - hostedFields.php page\r\n" . $error->code .": ". $error->message, FILE_APPEND);
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
			include_once(LIB_PATH . DS . "inc" . DS . "ParseObject.php");

			echo "Transaction detaiils: <br>";
			echo "id = ". $txn->id ."<br>";
			echo "status = ". $txn->status ."<br>";
			echo "type = ". $txn->type ."<br>";
			echo "amount = ". $txn->amount ."<br>";
			echo "merchantAccountId = ". $txn->merchantAccountId ."<br>";
			echo "subMerchantAccountId = ". $txn->subMerchantAccountId ."<br>";
			echo "masterMerchantAccountId = ". $txn->masterMerchantAccountId ."<br>";
			echo "orderId = ". $txn->orderId ."<br>";
			foreach($txn->createdAt as $key){
				echo gettype($key);
			}
			$createdAt = $txn->createdAt;
			echo "createdAt Date = ". $createdAt->format('Y-m-d H:i:s') ."<br>";
			$updatedAt = $txn->updatedAt;
			echo "updatedAt Date = ". $updatedAt->format('Y-m-d H:i:s') ."<br>";
			echo "customer Id = ". $txn->customer['id'] ."<br>";
			echo "customer firstName = ". $txn->customer['firstName'] ."<br>";
			echo "customer lastName = ". $txn->customer['lastName'] ."<br>";
			echo "customer company = ". $txn->customer['company'] ."<br>";
			echo "customer email = ". $txn->customer['email'] ."<br>";
			echo "customer phone = ". $txn->customer['phone'] ."<br>";
			echo "customer fax = ". $txn->customer['fax'] ."<br>";
			echo "billing Id = ". $txn->billing['id'] ."<br>";
			echo "billing firstName = ". $txn->billing['firstName'] ."<br>";
			echo "billing lastName = ". $txn->billing['lastName'] ."<br>";
			echo "billing company = ". $txn->billing['company'] ."<br>";
			echo "billing streetAddress = ". $txn->billing['streetAddress'] ."<br>";
			echo "billing extendedAddress = ". $txn->billing['extendedAddress'] ."<br>";
			echo "billing locality = ". $txn->billing['locality'] ."<br>";
			echo "billing region = ". $txn->billing['region'] ."<br>";
			echo "billing postalCode = ". $txn->billing['postalCode'] ."<br>";
			echo "billing countryName = ". $txn->billing['countryName'] ."<br>";
			echo "billing countryCodeAlpha2 = ". $txn->billing['countryCodeAlpha2'] ."<br>";
			echo "billing countryCodeAlpha3 = ". $txn->billing['countryCodeAlpha3'] ."<br>";
			echo "billing countryCodeNumeric = ". $txn->billing['countryCodeNumeric'] ."<br>";
			echo "refundId = ". $txn->refundId ."<br>";
			for($i=0, $ii=count($txn->refundIds); $i<$ii; $i++){
				echo "refundIds$i = ". $txn->refundIds[$i] ."<br>";
			}
			echo "refundedTransactionId = ". $txn->refundedTransactionId ."<br>";
			for($i=0, $ii=count($txn->partialSettlementTransactionIds); $i<$ii; $i++){
				echo "partialSettlementTransactionIds$i = ". $txn->partialSettlementTransactionIds[$i] ."<br>";
			}
			echo "authorizedTransactionId = ". $txn->authorizedTransactionId ."<br>";
			echo "settlementBatchId = ". $txn->settlementBatchId ."<br>";
			echo "shipping ID = ". $txn->shipping['id'] ."<br>";
			echo "shipping firstName = ". $txn->shipping['firstName'] ."<br>";
			echo "shipping lastName = ". $txn->shipping['lastName'] ."<br>";
			echo "shipping company = ". $txn->shipping['company'] ."<br>";
			echo "shipping streetAddress = ". $txn->shipping['streetAddress'] ."<br>";
			echo "shipping extendedAddress = ". $txn->shipping['extendedAddress'] ."<br>";
			echo "shipping locality = ". $txn->shipping['locality'] ."<br>";
			echo "shipping region = ". $txn->shipping['region'] ."<br>";
			echo "shipping postalCode = ". $txn->shipping['postalCode'] ."<br>";
			echo "shipping countryName = ". $txn->shipping['countryName'] ."<br>";
			echo "shipping countryCodeAlpha2 = ". $txn->shipping['countryCodeAlpha2'] ."<br>";
			echo "shipping countryCodeAlpha3 = ". $txn->shipping['countryCodeAlpha3'] ."<br>";
			echo "shipping countryCodeNumeric = ". $txn->shipping['countryCodeNumeric'] ."<br>";
			echo "customFields = ". $txn->customFields ."<br>";
			echo "avsErrorResponseCode = ". $txn->avsErrorResponseCode ."<br>";
			echo "avsPostalCodeResponseCode = ". $txn->avsPostalCodeResponseCode ."<br>";
			echo "avsStreetAddressResponseCode = ". $txn->avsStreetAddressResponseCode ."<br>";
			echo "cvvResponseCode = ". $txn->cvvResponseCode ."<br>";
			echo "gatewayRejectionReason = ". $txn->gatewayRejectionReason ."<br>";
			echo "processorAuthorizationCode = ". $txn->processorAuthorizationCode ."<br>";
			echo "processorResponseCode = ". $txn->processorResponseCode ."<br>";
			echo "processorResponseText = ". $txn->processorResponseText ."<br>";
			echo "additionalProcessorResponse = ". $txn->additionalProcessorResponse ."<br>";
			echo "voiceReferralNumber = ". $txn->voiceReferralNumber ."<br>";
			echo "purchaseOrderNumber = ". $txn->purchaseOrderNumber ."<br>";
			echo "taxAmount = ". $txn->taxAmount ."<br>";
			echo "taxExempt = ". $txn->taxExempt ."<br>";
			echo "creditCard token = ". $txn->creditCard['token'] ."<br>";
			echo "creditCard bin = ". $txn->creditCard['bin'] ."<br>";
			echo "creditCard last4 = ". $txn->creditCard['last4'] ."<br>";
			echo "creditCard cardType = ". $txn->creditCard['cardType'] ."<br>";
			echo "creditCard expirationMonth = ". $txn->creditCard['expirationMonth'] ."<br>";
			echo "creditCard expirationYear = ". $txn->creditCard['expirationYear'] ."<br>";
			echo "creditCard customerLocation = ". $txn->creditCard['customerLocation'] ."<br>";
			echo "creditCard cardholderName = ". $txn->creditCard['cardholderName'] ."<br>";
			echo "creditCard imageUrl = ". $txn->creditCard['imageUrl'] ."<br>";
			echo "creditCard prepaid = ". $txn->creditCard['prepaid'] ."<br>";
			echo "creditCard healthcare = ". $txn->creditCard['healthcare'] ."<br>";
			echo "creditCard debit = ". $txn->creditCard['debit'] ."<br>";
			echo "creditCard durbinRegulated = ". $txn->creditCard['durbinRegulated'] ."<br>";
			echo "creditCard commercial = ". $txn->creditCard['commercial'] ."<br>";
			echo "creditCard payroll = ". $txn->creditCard['payroll'] ."<br>";
			echo "creditCard issuingBank = ". $txn->creditCard['issuingBank'] ."<br>";
			echo "creditCard countryOfIssuance = ". $txn->creditCard['countryOfIssuance'] ."<br>";
			echo "creditCard productId = ". $txn->creditCard['productId'] ."<br>";
			echo "creditCard uniqueNumberIdentifier = ". $txn->creditCard['uniqueNumberIdentifier'] ."<br>";
			echo "creditCard venmoSdk = ". $txn->creditCard['venmoSdk'] ."<br>";
			
			// @TODO make this cleaner and show a user-friendly message that only shows pertinent fields
			echo "planId = ". $txn->planId ."<br>";
			echo "subscriptionId = ". $txn->subscriptionId ."<br>";
			echo "subscriptionId billingPeriodEndDate = ". $txn->subscriptionId['billingPeriodEndDate'] ."<br>";
			echo "subscriptionId billingPeriodStartDate = ". $txn->subscriptionId['billingPeriodStartDate'] ."<br>";
			for($i=0, $ii=count($txn->addOns); $i<$ii; $i++){
				echo "addOns$i = ". $txn->addOns[$i] ."<br>";
			}
			for($i=0, $ii=count($txn->discounts); $i<$ii; $i++){
				echo "discounts$i = ". $txn->discounts[$i] ."<br>";
			}
			echo "Transaction descriptor phone: ". $txn->descriptor['phone'] ."<br>";
			echo "Transaction descriptor url: ". $txn->descriptor['url'] ."<br>";
			echo "Transaction recurring: "; echo ($txn->recurring)? 'true': 'false';
			echo "Transaction channel: ". $txn->channel ."<br>";
			echo "Transaction serviceFeeAmount: ". $txn->serviceFeeAmount ."<br>";
			echo "Transaction escrowStatus: ". $txn->escrowStatus ."<br>";
			echo "Transaction escrowStatus: ". $txn->escrowStatus ."<br>";

			// @TODO not done
		} // END if($result->success)
	} else { // END if(isset($_POST['payment_method_nonce']))
	showBTHeader("Hosted Fields", "Hosted Fields");
	showBTLeftNav();
?>
		<div class="col-md-7">
			<div class="row">
				<div class="col-md-12">
					<h3>Pay with PayPal</h3>
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
	
	<script src="https://js.braintreegateway.com/js/braintree-2.24.1.min.js"></script>
	<script>
	braintree.setup(
		"<?=$clientToken?>",
		"custom", 
		{
			id: 'hostedCheckoutForm',
			paypal: {
				container: "paypalContainer",
				singleUse: true,
				amount: $("#amt").val(),
				currency: "USD",
				locale: "en_us",
				enableShippingAddress: true
			},
			hostedFields: {
				styles: {
					'input': {
						'font-size': '14px',
						'color': 'blue'
					}
				},
				number: {
					selector: "#cardNum",
					placeholder: "Card Number"
				},
				cvv: {
					selector: "#cvv",
					placeholder: "CVV"
				},
				postalCode: {
					selector: "#zip",
					placeholder: "Postal Code"
				},
				expirationDate: {
					selector: "#expDate",
					placeholder: "Expiration Date"
				}
			}
		});
	</script>
<?php
showBTFooter();
}
?>