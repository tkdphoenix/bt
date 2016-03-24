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
		<div class="col-md-7">
			<div class="row">
				<div class="col-md-12">
					<form id="checkoutForm" method="post" action="?">
						<input type="number" id="cardNum" name="cardNum" placeholder="Card number" tabindex="1">
						<input type="number" id="cvv" name="cvv" placeholder="CVV" tabindex="2">
						<input type="text" id="zip" name="zip" placeholder="Postal Code" tabindex="3">
						<input type="date" id="expDate" name="expDate" placeholder="Expiration Date" tabindex="4">
						<input name="amt" type="hidden" value="10.00">
						<input name="submit" type="submit" value="Pay $10">
					</form>
				</div>
			</div>
		</div>
	<?php
	} // END showForm()
	// test if the nonce has been posted
	if(isset($_POST['submit'])){
		if(isset($_POST['payment_method_nonce'])){
			$nonce = $_POST['payment_method_nonce'];
			$amt = $_POST['amt'];
			echo "nonce = ". $nonce ."\r\n";
			echo "amt = ". $amt ."\r\n";

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
				echo "merchantAccountId = ". $txn->merchantAccountId ."<br>";
				echo "orderId = ". $txn->orderId ."<br>";
				echo parseObj($txn->createdAt, "createdAt");
				echo parseObj($txn->updatedAt, "updatedAt");
				echo parseObj($txn->customer, "customer");
				echo parseObj($txn->billing, "billing");
				echo "refundId = ". $txn->refundId ."<br>";
				echo parseObj($txn->refundIds, "refundIds");
				echo "refundedTransactionId = ". $txn->refundedTransactionId ."<br>";
				echo "settlementBatchId = ". $txn->settlementBatchId ."<br>";
				echo parseObj($txn->shipping, "shipping");
				echo "customFields = ". $txn->customFields ."<br>"; // string??
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
				echo parseObj($txn->creditCard, "creditCard");
				echo parseObj($txn->Braintree_Transaction_StatusDetails, "Braintree_Transaction_StatusDetails");
				echo "planId = ". $txn->planId ."<br>";
				echo "subscriptionId = ". $txn->subscriptionId ."<br>";
				echo parseObj($txn->subscription, "subscription");
		} // END if($result->success)


		}
	} else { // END if(isset($_POST['submit']))
	showBTHeader("Hosted Fields", "Hosted Fields");
	showBTLeftNav();
	showForm();
?>

	
	<script src="https://js.braintreegateway.com/v2/braintree.js"></script>
	<script>
	braintree.setup(
		"<?=$clientToken?>",
		'custom', 
		{
			id: 'checkoutForm',
			hostedFields: {
				number: {
					selector: "#cardNum"
				},
				cvv: {
					selector: "#cvv"
				},
				postalCode: {
					selector: "#zip"
				},
				expirationDate: {
					selector: "#expDate"
				}
			}
		});
	</script>
<?php
showBTFooter();
}
?>