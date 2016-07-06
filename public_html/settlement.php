<?php
	defined("DS")? null : require_once(realpath(dirname(__FILE__) . DIRECTORY_SEPARATOR . "..") . DIRECTORY_SEPARATOR . "inc" . DIRECTORY_SEPARATOR . "initialize.php");

	require_once(LIB_PATH . DS . "inc" . DS . "common.inc.php");
	require_once(LIB_PATH . DS . "btVars.php");

	function showForm(){
	?>
		<div class="col-md-7">
			<div class="row">
				<div class="col-md-12">
					<form id="voidForm" class="form-horizontal" method="post" action="<?php echo htmlspecialchars("?"); ?>">
						<label for="txnID" class="sr-only">Transaction ID</label>
						<input type="text" id="txnID" name="txnID" tabindex="1" aria-label="Transaction ID" placeholder="Transaction ID" <?php if (isset($txnid)){echo "value='$txnid'"; }?>>
						<input type="submit" id="submitVoid" class="btn greenBtn" name="submitVoid" aria-label="Settle Transaction button" value="Settle Transaction">
					</form>
				</div>
			</div>
		</div>
	<?php
	}

	if(!empty($_POST)){
		showBTHeader("Transaction Settlement", "Transaction Settlement");
		showBTLeftNav();

		if(isset($_POST['txnID'])){
			$txnid = strip_tags($_POST['txnID']);
			echo "<h1>Here is the txnid: $txnid</h1>";
			$result = Braintree_Transaction::submitForSettlement($txnid);
			if(!empty($result)){
				if ($result->success) {
					echo "Your transaction was successful!";
				} else {
					echo "There was a problem.";
					print_r($result->errors);
				}
			} else {
				echo "There was no result!<br>";
			}
		}

	} else {
		showBTHeader("Transaction Settlement", "Results");
		showBTLeftNav();
		showForm();
	}


?>
</body>
</html>