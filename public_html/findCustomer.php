<?php
defined("DS")? null : require_once(realpath(dirname(__FILE__) . DIRECTORY_SEPARATOR . "..") . DIRECTORY_SEPARATOR . "inc" . DIRECTORY_SEPARATOR . "initialize.php");

require_once(LIB_PATH . DS . "btVars.php");
require_once(LIB_PATH . DS . "inc" . DS . "common.inc.php");

showBTHeader("Find Customer", "Find Customer");


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
								<input type="text" id="custId" class="form-control" name="custId" value="<?php echo (isset($_POST['custId']))? strip_tags($_POST['custId']): ''; ?>" placeholder="Customer ID" required>
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
		$custId = strip_tags($_POST['custId']);
		// @TODO add try/catch block
		$customer = Braintree_Customer::find($custId);
	} else { // @TODO - else provide error message that a customer ID is required

	}

	// @TODO - style results so it looks good and provide navigation for page also
	// print_r($customer);
	showBTLeftNav();
?>
	<div class="col-md-10">
		<p>Results: </p>
		<p>customer ID: <?=$customer->id?></p>
		<p>Name: <?php echo $customer->firstName ." ". $customer->lastName?></p>
		<p>Company: <?=$customer->company?></p>
		<p>Email: <?=$customer->email?></p>
		<p>Phone: <?=$customer->phone?></p>
		<p>Website: <?=$customer->website?></p>
		<!-- <p>Credit Card Info: <?=$customer->id?></p> -->
		<!-- <p>customer ID: <?=$customer->id?></p>
		<p>customer ID: <?=$customer->id?></p>
		<p>customer ID: <?=$customer->id?></p>
		<p>customer ID: <?=$customer->id?></p> -->
<?php
	if(!empty($customer->creditCards) && isset($customer->creditCards[0]->billingAddress)){
		echo "<p>BillingAddress: ". $customer->creditCards[0]->billingAddress->streetAddress ." ". 
		$customer->creditCards[0]->billingAddress->locality .", ". 
		$customer->creditCards[0]->billingAddress->region ." ".
		$customer->creditCards[0]->billingAddress->postalCode;
	}
?>
	</div>
<?php	
} else { // the form has not been submitted, so display the form
	showForm();
}
?>
<script src="../js/btScript.js"></script>
<?php
showBTFooter();
?>
