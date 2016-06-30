<?php
session_start();
// prevent session hijacking
session_regenerate_id();

defined("DS")? null : require_once(realpath(dirname(__FILE__) . DIRECTORY_SEPARATOR . "..") . DIRECTORY_SEPARATOR . "inc" . DIRECTORY_SEPARATOR . "initialize.php");

require_once(LIB_PATH . DS . "inc" . DS . "common.inc.php");
require_once(LIB_PATH . DS . "btVars.php");
// create the clientToken
$clientToken = Braintree_ClientToken::generate();

// if form has been submitted
if(isset($_POST['submitPmt'])){
	if(isset($_POST['paymentType'])){
		if($_POST['paymentType'] === "token"){
			$token = strip_tags($_POST['paymentToken']);
			// use token to create txn with Braintree_Transaction::sale()
			$result = Braintree_Transaction::sale([
				'amount' => '10.00',
				'paymentMethodToken' => $token,
				'options' => [
					'submitForSettlement' => true
				]
			]);
		} elseif($_POST['paymentType'] === "custId"){
			$custId = strip_tags($_POST['paymentToken']);
			// use customer ID to create txn with Braintree_Transaction::sale()
			$result = Braintree_Transaction::sale([
				'amount' => '10.00',
				'customerId' => $custId,
				'options' => [
					'submitForSettlement' => true
				]
			]);			
		} // END elseif($_POST['paymentType'] === "custId")
	} // END if(isset($_POST['paymentType']))
} // END if(isset($_POST['submitPmt']))

// test if $result is successful
if(isset($result)){
	if($result->success){
		echo "Payment Successful";
	} else {
		print_r($result);
	}
}

// token 7p2h66
// custId Joel_testerson


// insert doc head
showBTHeader("Pay with Token Page", "Pay with Token");
showBTLeftNav();
?>
<div class="col-md-7">
	<div class="row">
		<div class="col-md-12">
			

			<!-- depending on which radio option is selected, the button will change and the name of the field to post -->
			<form id="pmtForm" class="form-horizontal" method="post" action="<?php echo htmlspecialchars("?"); ?>">
				<div class="radio">
					<div class="row">
						<div class="col-md-3">
							<label for="token">
								<input id="token" type="radio" name="paymentType" value="token" checked>
							Use Payment Method Token</label>
						</div>
						<div class="col-md-3">
							<label for="custId">
								<input id="custId" type="radio" name="paymentType" value="custId">
							Use Customer ID</label>
						</div>
						<div class="col-md-6">
							<input type="text" name="paymentToken" tabindex="20">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-3">
						<input class="btn greenBtn" type="submit" name="submitPmt" value="Submit" tabindex="30">
					</div>
					<div class="col-md-9"></div>
				</div>
			</form>
		</div>
	</div>
</div>
<?php
showBTFooter();
?>
