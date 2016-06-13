<?php
session_start();
// prevent session hijacking
session_regenerate_id();

defined("DS")? null : require_once(realpath(dirname(__FILE__) . DIRECTORY_SEPARATOR . "..") . DIRECTORY_SEPARATOR . "inc" . DIRECTORY_SEPARATOR . "initialize.php");

require_once(LIB_PATH . DS . "inc" . DS . "common.inc.php");
require_once(LIB_PATH . DS . "btVars.php");

function showForm(){
?>
	<div class="col-md-7">
		<div class="row">
			<div class="col-md-12">
				<form action="?" method="post" id="voidForm">
					<input type="text" id="txnID" name="txnID" tabindex="1" placeholder="Transaction ID" <?php if (isset($txnid)){echo "value='$txnid'"; }?>>
					<input type="submit" id="submitVoid" name="submitVoid" value="Refund transactions">
				</form>
			</div>
		</div>
	</div>
<?php
}
if(isset($_POST['txnID'])){
	showBTHeader("Refund Transactions", "Results");
	showBTLeftNav();
	$txnid = strip_tags($_POST['txnID']);
	// @TODO add try / catch block once errors are understood and result object (see createCustomer.php - ln 267)
	$result = Braintree_Transaction::refund($txnid);
?>
	<div class="col-md-7">
		<div class="row">
			<div class="col-md-12">
<?php
	if(!empty($result)){
		if ($result->success) {
			echo "<p>Your transaction was successful!</p>";
		} else {
			echo "<p>There was a problem.</p>";
			print_r($result->errors);
		}
	} else {
		echo "<p>There was no result!</p>";
	}
?>
			</div>
		</div>
	</div>
<?php
} else { // END if(isset($_POST['txnID']))
	showBTHeader("Refund Transactions", "Refund Transactions");
	showBTLeftNav();
	showForm();

}
showBTFooter();
?>
