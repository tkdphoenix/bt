<?php
	defined("DS")? null : require_once(realpath(dirname(__FILE__) . DIRECTORY_SEPARATOR . "..") . DIRECTORY_SEPARATOR . "inc" . DIRECTORY_SEPARATOR . "initialize.php");

	require_once(LIB_PATH . DS . "inc" . DS . "common.inc.php");
	require_once(LIB_PATH . DS . "btVars.php");

	$clientToken = Braintree_ClientToken::generate();

	// test if the nonce has been posted
	if(isset($_POST['submit'])){
		if(isset($_POST['payment_method_nonce'])){
			$nonce = $_POST['payment_method_nonce'];
			$amt = 30.00;

			try{
				$result = Braintree_Transaction::sale(array(
					'amount' => $amt,
					'paymentMethodNonce' => $nonce,
					'options' => array(
						'submitForSettlement' => false
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

					echo "<p>Your payment went through. You are the proud owner of a iPad charging cable!</p>";
					echo "<h3>Transaction detaiils:</h3>";
					echo "id = ". $txn->id ."</p>";
					echo "<p>status = ". $txn->status ."</p>";
					echo "<p>type = ". $txn->type ."</p>";
					echo "<p>amount = ". $txn->amount ."</p>";

				} else if (isset($result->errors)){ 
					throw new Exception("The transaction wasn't successful");
				}

			} catch (Exception $e){
				echo "<p class='error'>This payment could not be processed.". $e->getMessage() ."</p>";
				echo "<br><br>Transaction errors: <br>";
				var_dump($result->errors);			
			}
		} // END if(isset($_POST['payment_method_nonce']))
	} else { // end if(isset($_POST['payment_method_nonce']))
		showBTHeader("Braintree Initialization", "Welcome to Braintree!");
		showBTLeftNav();
?>
			<div class="col-md-7">
				<div class="row">
					<div class="col-md-3">
						<img class="cord" src="img/iphoneCord.jpeg" alt="iPhone Cord">
					</div>
					<div class="col-md-9">
						<p class="cordTxt">This is a simple payment for a $30 iPad charging cable.</p>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<form id="checkout" class="form-horizontal" method="post" action="?">
							<div class="form-group">
								<label for="num">Card Number
									<input id="num" class="form-control" data-braintree-name="number" value="4111111111111111">
								</label>
							</div>
							<div class="form-group">
								<label for="mo">Month
									<input id="mo" class="form-control" data-braintree-name="expiration_month" value="11">
								</label>
							</div>
							<div class="form-group">
								<label for="yr">Year (yy)
									<input id="yr" class="form-control" data-braintree-name="expiration_year" value="18">
								</label>
							</div>
							<div class="form-group">
								<label for="cvv">CVV
									<input id="cvv" class="form-control" data-braintree-name="cvv" value="111">
								</label>
							</div>
							<div class="form-group">
								<input class="btn greenBtn" type="submit" name="submit" id="submitCustom" value="Pay">
							</div>
						</form>
					</div>
				</div>
			</div>
			<script src="https://js.braintreegateway.com/v2/braintree.js"></script>
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