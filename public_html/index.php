<?php
	defined("DS")? null : require_once(realpath(dirname(__FILE__) . DIRECTORY_SEPARATOR . "..") . DIRECTORY_SEPARATOR . "inc" . DIRECTORY_SEPARATOR . "initialize.php");
	require_once(LIB_PATH . DS . "inc" . DS . "common.inc.php");
	require_once(LIB_PATH . DS . "btVars.php");

	$clientToken = Braintree_ClientToken::generate();

	// @TODO move form into showForm() function
	// @TODO add PWPP button
	
	// test if the nonce has been posted
	if(isset($_POST['payment_method_nonce'])){
		$nonce = strip_tags($_POST['payment_method_nonce']);
		// $nonce = "fake-valid-prepaid-nonce";
		$amt = strip_tags($_POST['amt']);

		try{
			$result = Braintree_Transaction::sale(array(
				'amount' => $amt,
				'paymentMethodNonce' => $nonce,
				'taxAmount' => '2.00',
				'options' => array(
					'submitForSettlement' => true
				)
			));

			if($result->success){
				showBTHeader("Simple Sales Transaction Response", "Response");
				showBTLeftNav();
?>
		<div class="col-md-7">
			<div class="row">
				<div class="col-md-12">
<?php
				$txn = $result->transaction;
				print_r($txn); exit();
				echo "<p>Your payment went through. You are the proud owner of a iPad charging cable!</p>";
				echo "<h3>Transaction detaiils:</h3>";
				echo "id = ". $txn->id ."</p>";
				echo "<p>status = ". $txn->status ."</p>";
				echo "<p>type = ". $txn->type ."</p>";
				echo "<p>amount = ". $txn->amount ."</p>";

			} else if (isset($result->errors)){ 
				throw new Exception("The transaction wasn't successful.");
			}
		} catch (Exception $e){
			echo "<p class='error'>This payment could not be processed.". $e->getMessage() ."</p>";
			echo "<br><br>Transaction errors: <br>";
			var_dump($result->errors->deepAll());
			echo "<br><br>";
			print_r($result->errors);
			echo "<br><br>";
			var_dump($result);		
		}
	} else { // END if(isset($_POST['payment_method_nonce']))
		showBTHeader("Braintree Initialization", "Welcome to Braintree!");
		showBTLeftNav();
?>
			<div class="col-md-7">
				<div class="row">
					<div class="col-md-3">
						<img class="cord" src="img/iphoneCord.jpeg" alt="iPhone Cord">
					</div>
					<div class="col-md-9">
						<p class="cordTxt">This is a simple payment to purchase an iPhone / iPad charging cable. You can change the price for <a class="greenLink" href="https://developers.braintreepayments.com/reference/general/testing/#test-amounts" target="_blank">testing purposes</a> using <a class="greenLink" href="https://developers.braintreepayments.com/reference/general/processor-responses/authorization-responses#decline-codes" target="_blank">processor decline codes</a> and <a class="greenLink" href="https://developers.braintreepayments.com/reference/general/processor-responses/avs-cvv-responses" target="_blank">gateway rejections</a>.</p>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<form id="checkout" class="form-horizontal" method="post" action="<?php echo htmlspecialchars("?"); ?>">
							<div class="form-group">
								<label for="num">Card Number</label>
									<input id="num" class="form-control" data-braintree-name="number" aria-label="Card Number" placeholder="Card Number" value="4111111111111111">
							</div>
							<div class="form-group">
								<label for="mo">Month</label>
									<input id="mo" class="form-control" data-braintree-name="expiration_month" aria-label="Month" placeholder="Month" value="11">
							</div>
							<div class="form-group">
								<label for="yr">Year (yy)</label>
									<input id="yr" class="form-control" data-braintree-name="expiration_year" aria-label="Year (yy)" placeholder="Year (yy)" value="18">
							</div>
							<div class="form-group">
								<label for="cvv">CVV</label>
									<input id="cvv" class="form-control" data-braintree-name="cvv" aria-label="CVV" placeholder="CVV" value="111">
							</div>
							<div class="form-group">
								<label for="amt">Amount
									<input type="number" id="amt" class="form-control" name="amt" aria-label="amount" placeholder="Amount" value="10">
								</label>
							</div>
							<div class="form-group">
								<input class="btn greenBtn" type="submit" name="submit" id="submitCustom" aria-label="Pay button" value="Pay">
							</div>
						</form>
					</div>
				</div>
			</div>
			<script src="https://js.braintreegateway.com/js/braintree-2.22.2.min.js"></script>
			<script>
				braintree.setup(
					"<?=$clientToken?>",
					'custom', {
					id: 'checkout'
					}
				);
			</script>
<?php
showBTFooter();
}
?>