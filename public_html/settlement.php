<?php
	defined("DS")? null : require_once(realpath(dirname(__FILE__) . DIRECTORY_SEPARATOR . "..") . DIRECTORY_SEPARATOR . "inc" . DIRECTORY_SEPARATOR . "initialize.php");

	require_once(LIB_PATH . DS . "inc" . DS . "common.inc.php");
	require_once(LIB_PATH . DS . "btVars.php");

	function showForm(){
	?>
		<div class="col-md-7">
			<div class="row">
				<div class="col-md-12">
					<form class="form-horizontal" action="?" method="post" id="voidForm">
						<input type="text" id="txnID" name="txnID" tabindex="1" placeholder="Transaction ID" <?php if (isset($txnid)){echo "value='$txnid'"; }?>>
						<input type="submit" id="submitVoid" name="submitVoid" value="Settle transactions">
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
			$txnid = $_POST['txnID'];
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