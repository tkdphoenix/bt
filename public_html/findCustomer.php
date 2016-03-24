<?php
defined("DS")? null : require_once(realpath(dirname(__FILE__) . DIRECTORY_SEPARATOR . "..") . DIRECTORY_SEPARATOR . "inc" . DIRECTORY_SEPARATOR . "initialize.php");

require_once(LIB_PATH . DS . "btVars.php");require_once("../inc/common.inc.php");

showBTHeader("Find Customer");


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
					<form id="newCustForm" action="?" method="post" class="form-horizontal">
						<h3>Find a Cusomter</h3>
						<div class="form-group">
							<label for="custId" class="col-md-3 control-label">Customer ID</label>
							<div class="col-md-9">
								<input type="text" id="custId" class="form-control" name="custId" value="<?php echo (isset($_POST['custId']))? $_POST['custId']: ''; ?>" placeholder="Customer ID" required>
							</div>
						</div>
						
						<input type="submit" name="findCustSubmit" value="Find Customer">	
					</form>
				</div>
			</div>
		</div>
<?php
} // end showForm()

// @TODO
// test submitted values

if(isset($_POST['findCustSubmit'])){ // if the form has been submitted
	if(!empty($_POST['custId'])){
		$custId = $_POST['custId'];
		$customer = Braintree_Customer::find($custId);
	} else { // @TODO - else provide error message that a customer ID is required

	}

	// @TODO - style results so it looks good and provide navigation for page also
	echo "Results: <br>";
	print_r($customer);
	echo "<br>";

	
} else { // the form has not been submitted, so display the form
	showForm();
}
?>
<script src="../js/btScript.js"></script>
<?php
showFooter();
?>
