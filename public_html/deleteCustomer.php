<?php
defined("DS")? null : require_once(realpath(dirname(__FILE__) . DIRECTORY_SEPARATOR . "..") . DIRECTORY_SEPARATOR . "inc" . DIRECTORY_SEPARATOR . "initialize.php");

require_once(LIB_PATH . DS . "btVars.php");
require_once(LIB_PATH . DS . "inc" . DS . "common.inc.php");

// @TODO may be able to get a list of customers to show in a table similar to other pages like createSubscription.php
function showSearchForm(){
?>
	<div class="col-md-7">
		<div class="row">
			<div class="col-md-12">
				<form id="searchForm" class="form-horizontal" method="post" action="<?php echo htmlspecialchars("?"); ?>" class="form-horizontal">
					<h3>Search for a Customer to Delete</h3>
					<div class="form-group">
						<label for="searchID" class="sr-only">Customer ID to search for</label>
						<div class="col-md-9">
							<input type="text" id="searchId" class="form-control" name="searchId" value="<?php echo (isset($_POST['searchId']))? strip_tags($_POST['searchId']): ''; ?>" aria-label="Customer ID to search for" placeholder="Customer ID to search for" required>
						</div>
					</div>
					<input class="btn greenBtn" type="submit" name="searchCustSubmit" value="Search Customer">
				</form>
			</div>
		</div>
	</div>
<?php
}


// @TODO - need to find customer to delete then bring user to this page and display details in the form. Call find customer to find the ID and inject the known values into the form 

/**
 *	This method shows the form when a condition is met.
 *
 *	@param $submitted (array) - Values must be submitted in order to confirm that the correct customer is about to be deleted.
 * 	@return - nothing is returned from this function, since HTML is produced on the page where the function is invoked.
 */
function deleteForm($submitted){
// optional way to parse values of array, but $key will come back like "firstName" or "email" instead of "First Name" or "Email"
// creating HTML list manually provides better control over how content is displayed on screen.
	// while (list($key, $val) = each($submitted)) {
	//     if(!empty($val)){
	// 	    echo "<p>$key: \t$val</p>";
	// 	}
	// }
?>
<div class="col-md-7">
	<div class="row">
		<div class="col-md-12">
			<h3 class="text-center">Please confirm that this is the correct customer <br>(this is the point of no return)</h3>
			<p>ID: <?=$submitted['customerId']?></p>
			<p>First Name: <?=$submitted['firstName']?></p>
			<p>Last Name: <?=$submitted['lastName']?></p>
			<p>Company: <?=$submitted['company']?></p>
			<p>Email: <?=$submitted['email']?></p>
			<p>Phone: <?=$submitted['phone']?></p>
			<p>Fax: <?=$submitted['fax']?></p>
			<p>Website: <?=$submitted['website']?></p>
			<form id="deleteCustForm" class="form-horizontal" method="post" action="<?php echo htmlspecialchars("?"); ?>" class="form-horizontal">
				<input type="hidden" name="customerId" value="<?php echo (isset($submitted['customerId']))? $submitted['customerId'] : ''; ?>" required>
				<input class="btn greenBtn" type="submit" name="deleteCustSubmit" value="Delete Customer">	
			</form>
		</div>
	</div>
</div>
<?php
} // end deleteForm()

// @TODO test submitted values

if(isset($_POST['deleteCustSubmit'])){ // if the form has been submitted
	if(isset($_POST['customerId'])){
		$customerId = strip_tags($_POST['customerId']);
		$result = Braintree_Customer::delete($customerId);
		if($result->success){
			showBTHeader("Delete Customer", "Customer Deleted");
			showBTLeftNav();
?>
			<div class="col-md-7">
				<div class="row">
					<div class="col-md-12">
<?php

			echo "<p>Your customer \"$customerId\" has been deleted.</p>";
			echo "<a id='another' class='btn greenBtn' href='deleteCustomer.php'>Delete another customer</a>";
			echo "</div>";
		} else {
			showBTHeader("Delete Customer", "Delete Customer Error");
			showBTLeftNav();
			// @TODO find and print errors
		}
	} else {
		showBTHeader("Delete Customer", "Value Not Submitted");
		showBTLeftNav();
?>
		<div class="col-md-7">
			<div class="row">
				<div class="col-md-12">
<?php
		echo "<p>It appears that you don't have the customer ID set for some reason. Please return to the <a href='deleteCustomer.php'>Delete Customer page</a> and begin again.</p>";
	}
?>
				</div>
			</div>
		</div>
<?php

// END if(isset($_POST['deleteCustSubmit']))
} elseif(!isset($_POST['deleteCustSubmit']) && !isset($_POST['searchCustSubmit'])){
	showBTHeader("Delete Customer", "Delete a Customer");
	showBTLeftNav();
	showSearchForm();
// @TODO - make sure the form is submitted to search for the customer so values can be added to the form, then insert values as params to the deleteForm() method. 
} elseif(isset($_POST['searchCustSubmit'])){
	$customerId = strip_tags($_POST['searchId']);

	$customer = Braintree_Customer::find($customerId);
	showBTHeader("Delete Customer", "This is the customer that will be Deleted");
	showBTLeftNav();
	// @TODO if customer is found

	// an array must be created to submit as the $submitted array parameter for the deleteForm() function.
	$custVals = array();
	// values from $customer object after find() method:
	$custVals['customerId']			= $customer->id;
	$custVals['firstName'] 			= $customer->firstName;
	$custVals['lastName'] 			= $customer->lastName;
	$custVals['company'] 			= $customer->company;
	$custVals['email'] 				= $customer->email;
	$custVals['phone'] 				= $customer->phone;
	$custVals['fax'] 				= $customer->fax;
	$custVals['website'] 			= $customer->website;

	// show the delete form
	deleteForm($custVals);
}
?>
<script src="../js/btScript.js"></script>
<?php
showBTFooter();
?>
