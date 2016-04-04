<?php
	defined("DS")? null : require_once(realpath(dirname(__FILE__) . DIRECTORY_SEPARATOR . "..") . DIRECTORY_SEPARATOR . "inc" . DIRECTORY_SEPARATOR . "initialize.php");

	require_once(LIB_PATH . DS . "inc" . DS . "common.inc.php");
	require_once(LIB_PATH . DS . "btVars.php");

	$clientToken = Braintree_ClientToken::generate();
	// echo "Your client token: ". $clientToken . "<br>";

	if(isset($_POST['payment_method_nonce'])){
		$nonce = $_POST['payment_method_nonce'];
		$amt = 50.00;
		showBTHeader("Braintree Initialization", "Results");
		showBTLeftNav();
		try{
			$result = Braintree_Transaction::sale(array(
				'amount' => $amt,
				'paymentMethodNonce' => $nonce,
				'options' => array(
					'submitForSettlement' => false
					// 'storeInVaultOnSuccess' => true,
				)
			));

			if($result->success){
				$cardType = $result->transaction->creditCard['cardType'];
?>
			<div class="col-md-7">
				<div class="row">
					<div class="col-md-12">
<?php
				$txn = $result->transaction;

				echo "<h3>Transaction detaiils:</h3>";
				echo "id = ". $txn->id ."</p>";
				echo "<p>status = ". $txn->status ."</p>";
				echo "<p>type = ". $txn->type ."</p>";
				echo "<p>amount = ". $txn->amount ."</p>";
?>
		<script>
			var nonce = "<?php echo (isset($nonce)) ? $nonce : '' ?>";
			var cardType = "<?php echo (isset($cardType)) ? $cardType : ''?>";
			console.info("The nonce: "+ nonce); console.info("Card type: "+ cardType);
		</script>
<?php
			} else if (isset($result->errors)){ 
				throw new Exception("The transaction wasn't successful");
			}

			// $result->success;
		} catch (Exception $e){
			echo "<p class='error'>This payment could not be processed.". $e->getMessage() ."</p>";
			echo "<br><br>Transaction errors: <br>";
			var_dump($result->errors);
		} // END catch block
	} else { // END if(isset($_POST['payment_method_nonce']))
	showBTHeader("Dropin UI", "Dropin UI");
	showBTLeftNav();
?>
	<div class="col-md-7">
		<div class="row">
			<div class="col-md-12">
				<form id="checkout" method="post" action="?">
					<div id="myDropin"></div>
					<input type="submit" value="Pay $50">
				</form>				
			</div>
		</div>
	</div>


	<script src="https://js.braintreegateway.com/js/braintree-2.22.2.min.js"></script>
	<script>
		var clientToken =   "<?=$clientToken?>";

		braintree.setup(clientToken, "dropin", {
		container: "myDropin"
		});
	</script>
<?php
	} // END else
?>
</body>
</html>