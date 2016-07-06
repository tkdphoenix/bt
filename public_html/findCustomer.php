<?php
defined("DS")? null : require_once(realpath(dirname(__FILE__) . DIRECTORY_SEPARATOR . "..") . DIRECTORY_SEPARATOR . "inc" . DIRECTORY_SEPARATOR . "initialize.php");

require_once(LIB_PATH . DS . "btVars.php");
require_once(LIB_PATH . DS . "inc" . DS . "common.inc.php");

// @TODO may be able to create a list of customers similar to createSubscription.php
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
					<form id="newCustForm" class="form-horizontal" method="post" action="<?php echo htmlspecialchars("?"); ?>">
						<div class="form-group">
							<label for="custId" class="col-md-3 sr-only">Customer ID</label>
							<div class="col-md-9">
								<input type="text" id="custId" class="form-control" name="custId" value="<?php echo (isset($_POST['custId']))? strip_tags($_POST['custId']): ''; ?>" aria-label="Customer ID" placeholder="Customer ID" required>
							</div>
						</div>
						
						<input class="btn greenBtn" type="submit" name="findCustSubmit" aria-label="Find Customer Button" value="Find Customer">	
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
		<h3>Results: </h3>
		<p>Customer ID: <?=$customer->id?></p>
		<p>Name: <?php echo $customer->firstName ." ". $customer->lastName?></p>
		<p>Company: <?=$customer->company?></p>
		<p>Email: <?=$customer->email?></p>
		<p>Phone: <?=$customer->phone?></p>
		<p>Website: <?=$customer->website?></p>
	<?php
		
	?>
		
		<!-- <p>customer ID: <?=$customer->id?></p>
		<p>customer ID: <?=$customer->id?></p>
		<p>customer ID: <?=$customer->id?></p>
		<p>customer ID: <?=$customer->id?></p> -->
<?php
	if(!empty($customer->creditCards) && isset($customer->creditCards[0]->billingAddress)){
		echo "<p>Credit Card Info:</p>";
		foreach($customer->creditCards as $card){
	?>
			<p><?=$card->bin?>******<?=$card->last4?> <img src="<?=$card->imageUrl?>" alt="Card type logo"> <?=$card->cardType?> 
			<?php echo ($card->default)? " (default payment method)" : ''?>
			</p>
			<p>Payment Method Token: <?=$card->token?></p>
			<p>Billing Address: <?=$card->billingAddress->streetAddress?><br>
			<?=$card->billingAddress->locality?>, <?=$card->billingAddress->region?> <?=$card->billingAddress->postalCode?></p>
<?php
		}
	}
?>
	</div>
<?php	
} else { // the form has not been submitted, so display the form
	showBTHeader("Find a Customer", "Find a Customer");
	showBTLeftNav();
	showForm();
}
?>
<script src="../js/btScript.js"></script>
<?php
showBTFooter();
?>
