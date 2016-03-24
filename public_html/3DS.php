<?php
	defined("DS")? null : require_once(realpath(dirname(__FILE__) . DIRECTORY_SEPARATOR . "..") . DIRECTORY_SEPARATOR . "inc" . DIRECTORY_SEPARATOR . "initialize.php");

	require_once(LIB_PATH . DS . "inc" . DS . "common.inc.php");
	require_once(LIB_PATH . DS . "btVars.php");

	$clientToken = Braintree_ClientToken::generate();

	if(isset($_POST['payment_method_nonce'])){
		$nonce = $_POST['payment_method_nonce'];
		echo $nonce;
		$amt = 500;
		// display header and leftNav
		showBTHeader("Braintree 3DS", "3DS Check");
		showBTLeftNav();

?>		
<script src="https://js.braintreegateway.com/js/braintree-2.21.0.min.js"></script>
<script>
// Using the generated client token to instantiate the Braintree client.
var client = new braintree.api.Client({
  clientToken: "<?=$clientToken?>"
});

client.verify3DS({
  amount: "<?=$amt?>",
  creditCard: "<?=$nonce?>"
}, function (error, response) {
	if (!error) {
		// 3D Secure finished. Using response.nonce you may proceed with the transaction with the associated server side parameters below.
		return true;
	} else {
		// Handle errors
		$(".leftNav").after("<h3>Errors</h3><p>"+ error.message +"</p>");
	}
});
</script>

<?php
		try{
			// After the verify3DS is run successfully you can call the sale() method
			$result = Braintree_Transaction::sale([
			    'amount' => $amt,
			    'paymentMethodNonce' => $nonce,
			    'options' => [
			        'three_d_secure' => [
			            'required' => true
			        ]
			    ]
			]);
			if($result->success){
				// header and left nav are already on the page
?>
		<div class="col-md-7">
			<div class="row">
				<div class="col-md-12">
<?php
				$txn = $result->transaction;

				echo "<p>Your payment went through. You are the proud owner of a MacBook Pro 13&quot;! What a great deal!</p>";
				echo "<h3>Transaction detaiils:</h3>";
				echo "id = ". $txn->id ."</p>";
				echo "<p>status = ". $txn->status ."</p>";
				echo "<p>type = ". $txn->type ."</p>";
				echo "<p>amount = ". $txn->amount ."</p>";
			} else { 
				throw new Exception("The transaction wasn't successful.");
				var_dump($result->errors);
			}
		} catch (Exception $e){
			echo 'Caught exception: ',  $e->getMessage(), "\n";
		}
	} else { // END if(isset($_POST['payment_method_nonce']))
		showBTHeader("Braintree 3DS", "Welcome to Braintree 3DS!");
		showBTLeftNav();
?>
			<div class="col-md-7">
				<div class="row">
					<div class="col-md-3">
						<img class="laptop" src="img/macBookPro.jpeg" alt="MacBook Pro 13&quot;">
					</div>
					<div class="col-md-9">
						<p class="cordTxt">This is a simple payment for a $500 MacBook Pro 13&quot; laptop.</p>
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
									<input id="yr" class="form-control" data-braintree-name="expiration_year" value="22">
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


