<?php
session_start();
defined("DS")? null : require_once(realpath(dirname(__FILE__) . DIRECTORY_SEPARATOR . "..") . DIRECTORY_SEPARATOR . "inc" . DIRECTORY_SEPARATOR . "initialize.php");

require_once(LIB_PATH . DS . "inc" . DS . "common.inc.php");
require_once(LIB_PATH . DS . "btVars.php");

function showSearchForm(){
?>
	<div class="col-md-7">
		<div class="row">
			<div class="col-md-12">
				<form action="?" id="searchForm" method="post" class="form-horizontal">
					<h3>Search for a Customer to Update</h3>
					<div class="form-group">
						<label for="searchID">Customer ID to search for</label>
						<div class="col-md-9">
							<input type="text" id="searchId" class="form-control" name="searchId" value="<?php echo (isset($_POST['searchId']))? $_POST['searchId']: ''; ?>" required>
						</div>
					</div>

						<input class="btn greenBtn" type="submit" name="searchCustSubmit" value="Search Customer">

				</form>
			</div>
		</div>
	</div>
<?php
}


// @TODO - need to find customer to update then bring user to this page and display details in the form. Call find customer to find the ID and inject the known values into the form 

/**
 *	This method shows the form when a condition is met.
 *
 *	@param $submitted (array) - If the form has been previously submitted the values can be pulled from here instead of asking the user to fill them out again. This parameter is optional.
 *	@param $errorsArray (array) - an array that contains all of the errors from the form validation after submission (server side validation) and their messages to be displayed on the page if errors are found. The errors should appear at the top of the form. This parameter is optional.
 * @return - nothing is returned from this function, since HTML is produced on the page where the function is invoked.
 */
function showForm($submitted = array(), $errorsArr=[]){
	if(!empty($errorsArr)){
		foreach($errorsArr as $errMsg){
			echo "<p class='alert alert-danger'>". $errMsg ."</p>";
		}
	}
?>
	<div class="col-md-7">
		<div class="row">
			<div class="col-md-12">
				<form id="updateCustForm" action="?" method="post" class="form-horizontal">
					<h3>Customer Details</h3>
					<div class="form-group">
						<label for="first" class="col-md-3 control-label">First Name</label>
						<div class="col-md-9">
							<input type="text" id="first" class="form-control" name="first" value="<?php echo (isset($submitted['firstName']))? $submitted['firstName']: ''; ?>" required>
						</div>
					</div>
					
					<div class="form-group">
						<label for="last" class="col-md-3 control-label">Last Name</label>
						<div class="col-md-9">
							<input type="text" id="last" class="form-control" name="last" value="<?php echo (isset($submitted['lastName']))? $submitted['lastName']: ''; ?>" required>
						</div>
					</div>
					
					<div class="form-group">
						<label for="company" class="col-md-3 control-label">Company</label>
						<div class="col-md-9">
							<input type="text" id="company" class="form-control" name="company" value="<?php echo (isset($submitted['company']))? $submitted['company']: ''; ?>">
						</div>
					</div>
					
					<div class="form-group">
						<label for="email" class="col-md-3 control-label">Email </label>
						<div class="col-md-9">
							<input type="email" id="email" class="form-control" name="email" value="<?php echo (isset($submitted['email']))? $submitted['email']: ''; ?>" required>
						</div>
					</div>
					
					<div class="form-group">
						<label for="phone" class="col-md-3 control-label">Phone </label>
						<div class="col-md-9">
							<input type="tel" id="phone" class="form-control" name="phone" value="<?php echo (isset($submitted['phone']))? $submitted['phone']: ''; ?>" required>
						</div>
					</div>

					<div class="form-group">
						<label for="fax" class="col-md-3 control-label">Fax </label>
						<div class="col-md-9">
							<input type="tel" id="fax" class="form-control" name="fax" value="<?php echo (isset($submitted['fax']))? $submitted['fax']: ''; ?>">
						</div>
					</div>

					<div class="form-group">
						<label for="website" class="col-md-3 control-label">Website </label>
						<div class="col-md-9">
							<input type="url" id="website" class="form-control" name="website" value="<?php echo (isset($submitted['website']))? $submitted['website']: ''; ?>">
						</div>
					</div>

					<h3>Payment Method Details</h3>
					<div class="radio">
						<div class="row">
							<div class="col-md-3">
								<label>
									<input type="radio" id="without" class="radioPmtMethod" name="withPmtMethodRadio" value="false">
								Without Payment Method</label>						
							</div>
							<div class="col-md-9"></div>
						</div>
						<div class="row">
							<div class="col-md-3">
								<label>
									<input type="radio" id="with" class="radioPmtMethod" name="withPmtMethodRadio" value="true" checked>
								With Payment Method</label>
							</div>
							<div class="col-md-9"></div>						
						</div>
					</div> <!-- end .radio -->
						
					<div class="paymentMethodDetails">
						<div class="form-group">
							<label for="cardholderName" class="col-md-2 control-label">Cardholder Name</label>
							<div class="col-md-2">
								<input type="text" class="form-control" name="cardholderName" value="<?php echo (isset($submitted['cardholderName']))? $submitted['cardholderName']: ''; ?>" placeholder="First Last">
							</div>
						
							<label for="number" class="col-md-2 control-label">Credit Card Number</label>
							<div class="col-md-3">
								<input type="text" class="form-control" name="number" value="<?php echo (isset($submitted['number']))? $submitted['number']: ''; ?>" placeholder="Credit Card Number">
							</div>
						</div>

						<div class="form-group">	
							<label for="expirationMonth" class="col-md-2 control-label">Expiration Date</label>
							<div class="col-md-2">
								<input type="text" class="form-control" name="expirationDate" value="<?php echo (isset($submitted['expirationDate']))? $submitted['expirationDate']: ''; ?>" placeholder="Expiration Date (MM/YYYY)">
							</div>

							<label for="token" class="col-md-2 control-label">Payment Method Token</label>
							<div class="col-md-2">
								<input type="text" class="form-control" name="token" value="<?php echo (isset($submitted['token']))? $submitted['token']: ''; ?>" placeholder="Payment Method Token">
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-offset-2 col-md10">
								<div class="checkbox">
									<label>
										<input type="checkbox" name="makeDefault"> Make Default
									</label>
								</div>
							</div>
						</div>
					</div> <!-- end .paymentMethodDetails -->

					<h3>Billing Address</h3>
					<div class="radio">
						<div class="row">
							<div class="col-md-3">
								<label>
									<input type="radio" id="noBillingAddr" class="radioBillingAddr" name="withBillingAddressRadio" value="false">
								None</label>						
							</div>
							<div class="col-md-9"></div>
						</div>
						<div class="row">
							<div class="col-md-3">
								<label>
									<input type="radio" id="withBillingAddr" class="radioBillingAddr" name="withBillingAddressRadio" value="true" checked>
								Create New Address</label>
							</div>
							<div class="col-md-9"></div>						
						</div>
					</div> <!-- end .radio -->


					<div class="billingAddressDetails">
						<!-- billing address info -->			
						<div class="form-group">
							<label for="firstName" class="col-md-3 control-label">First Name</label>
							<div class="col-md-9">
								<input type="text" class="form-control" name="billing_firstName" value="<?php echo (isset($submitted['billing_firstName']))? $submitted['billing_firstName']: ''; ?>" placeholder="First Name">
							</div>
						</div>
						
						<div class="form-group">
							<label for="lastName" class="col-md-3 control-label">Last Name</label>
							<div class="col-md-9">
								<input type="text" class="form-control" name="billing_lastName" value="<?php echo (isset($submitted['billing_lastName']))? $submitted['billing_lastName']: ''; ?>" placeholder="Last Name">
							</div>
						</div>
						
						<div class="form-group">
							<label for="company" class="col-md-3 control-label">Company</label>
							<div class="col-md-9">
								<input type="text" class="form-control" name="billing_company" value="<?php echo (isset($submitted['billing_company']))? $submitted['billing_company']: ''; ?>" placeholder="Company">
							</div>
						</div>
						
						<div class="form-group">
							<label for="streetAddress" class="col-md-3 control-label">Street Address</label>
							<div class="col-md-9">
								<input type="text" class="form-control" name="streetAddress" value="<?php echo (isset($submitted['streetAddress']))? $submitted['streetAddress']: ''; ?>" placeholder="Street Address">
							</div>
						</div>
						
						<div class="form-group">
							<label for="extendedAddress" class="col-md-3 control-label">Address 2</label>
							<div class="col-md-9">
								<input type="text" class="form-control" name="extendedAddress" value="<?php echo (isset($submitted['extendedAddress']))? $submitted['extendedAddress']: ''; ?>" placeholder="Address 2">
							</div>
						</div>
						
						<div class="form-group">
							<label for="locality" class="col-md-3 control-label">City</label>
							<div class="col-md-9">
								<input type="text" class="form-control" name="locality" value="<?php echo (isset($submitted['locality']))? $submitted['locality']: ''; ?>" placeholder="City">
							</div>
						</div>
						
						<div class="form-group">
							<label for="region" class="col-md-3 control-label">State / Province (Region)</label>
							<div class="col-md-9">
								<input type="text" class="form-control" name="region" value="<?php echo (isset($submitted['region']))? $submitted['region']: ''; ?>" placeholder="State / Province (Region)">
							</div>
						</div>
						
						<div class="form-group">
							<label for="postalCode" class="col-md-3 control-label">Postal Code</label>
							<div class="col-md-9">
								<input type="num" class="form-control" name="postalCode" value="<?php echo (isset($submitted['postalCode']))? $submitted['postalCode']: ''; ?>" placeholder="Postal Code">
							</div>
						</div>
						
						<div class="form-group">
							<label for="countryName" class="col-md-3 control-label">Country Name</label>
							<div class="col-md-9">
								<?php include("../inc/countries.inc.php"); ?>
							</div>
						</div>
					</div> <!-- end .billingAddressDetails -->

					<input type="submit" name="updateCustSubmit" value="Update Customer">	
				</form>
			</div>
		</div>
	</div>
<?php
} // end showForm()

// @TODO
// test submitted values

if(isset($_POST['updateCustSubmit'])){ // if the form has been submitted
	showBTHeader("Update Customer", "Updated Customer Info");
	showBTLeftNav();
	$errorsArr = [];
	$customerDetails = array(
		"firstName"			=> $_POST['first'],
		"lastName"			=> $_POST['last'],
		"company"			=> $_POST['company'],
		"email"				=> $_POST['email'],
		"phone"				=> $_POST['phone'],
		"fax"				=> $_POST['fax'],
		"website"			=> $_POST['website']
	);

	if(isset($_COOKIE['customerId'])){
		$customerId = $_COOKIE['customerId'];
	}

	//@TODO validate inputs before submitting
	// update values for customer
	if(isset($customerId)){
		$result = Braintree_Customer::update($customerId, $customerDetails);
		if($result->success){
?>
		<div class="col-md-7">
			<div class="row">
				<div class="col-md-12">
<?php
			echo "<p>Your customer $customerId has been updated with the following values:</p>";
			if(!empty($result->customer->firstName)){
				echo "<p>First Name: \t". $result->customer->firstName ."</p>";
			}
			if(!empty($result->customer->lastName)){
				echo "<p>Last Name: \t". $result->customer->lastName ."</p>";
			}
			if(!empty($result->customer->company)){
				echo "<p>Company: \t". $result->customer->company ."</p>";
			}
			if(!empty($result->customer->email)){
				echo "<p>Email: \t". $result->customer->email ."</p>";
			}
			if(!empty($result->customer->phone)){
				echo "<p>Phone: \t". $result->customer->phone ."</p>";
			}
			if(!empty($result->customer->fax)){
				echo "<p>Fax: \t". $result->customer->fax ."</p>";
			}
			if(!empty($result->customer->website)){
				echo "<p>Website: \t". $result->customer->website ."</p>";
			}
			echo "<a id='another' class='btn greenBtn' href='updateCustomer.php'>Update another customer</a>";
?>
				</div>
			</div>
		</div>
<?php
		} else {
			// find and print errors
		}

	} else {
		echo "<p>It appears that you don't have the customer ID set for some reason. Please return to the <a href='updateCustomer.php'>updateCustomer page</a> and begin again.</p>";
	}

	if($_POST['withPmtMethodRadio'] === "true"){ // if payment method details are submitted, set those variables

		$creditCard = array(
			"cardholderName" 	=> $_POST['cardholderName'],
			"number"			=> $_POST['number'],
			"expirationDate"	=> $_POST['expirationDate'],
			"token"				=> $_POST['token']
		);

		// @TODO validate values before submitting
		// submit the $creditCard array to add it as a payment method
		// @TODO braintree method here
	} // END if($_POST['withPmtMethodRadio'] === "true")
	
	if($_POST['withBillingAddressRadio'] != 0){
		$billingAddress = array(
			"firstName"			=> $_POST['billing_firstName'],
			"lastName"			=> $_POST['billing_lastName'],
			"company"			=> $_POST['billing_company'],
			"streetAddress"		=> $_POST['streetAddress'],
			"extendedAddress"	=> $_POST['extendedAddress'],
			"locality"			=> $_POST['locality'],
			"region"			=> $_POST['region'],
			"postalCode"		=> $_POST['postalCode'],
			"countryName"		=> $_POST['country']
		);

		// @TODO validate values before submitting
		// submit the $billingAddress array to add it as a billing address
		// @TODO braintree method here
	} // END if($_POST['withBillingAddressRadio'] != 0)

// END if(isset($_POST['updateCustSubmit']))
} elseif(!isset($_POST['updateCustSubmit']) && !isset($_POST['searchCustSubmit'])){
	showBTHeader("Update Customer", "Update a Customer");
	showBTLeftNav();
	showSearchForm();
// @TODO - make sure the form is submitted to search for the customer so values can be added to the form, then insert values as params to the showForm() method. 
} elseif(isset($_POST['searchCustSubmit'])){
	showBTHeader("Update Customer", "Choose Which Values to Update");
	showBTLeftNav();
?>
	<script>
		// the header has already been set, so set the cookie to remember the customer ID on the client side
		var customerId = "<?=$_POST['searchId']?>";
		var d = new Date();
		d.setTime(d.getTime() + (24*60*60*1000)); // 1 day
		d = d.toUTCString();

		document.cookie="customerId="+ customerId +"; expires="+ d;
	</script>
<?php
	$customerId = $_POST['searchId'];

	$customer = Braintree_Customer::find($customerId);

	// an array must be created to submit as the $submitted array parameter for the showForm() function.
	$custVals = array();
	// values from $customer object after find() method:
	$custVals['id']					= $customer->id;
	$custVals['firstName'] 			= $customer->firstName;
	$custVals['lastName'] 			= $customer->lastName;
	$custVals['company'] 			= $customer->company;
	$custVals['email'] 				= $customer->email;
	$custVals['phone'] 				= $customer->phone;
	$custVals['fax'] 				= $customer->fax;
	$custVals['website'] 			= $customer->website;
	// $custVals['date'] 				= $customer->createdAt->date;
	// $custVals['timezone_type'] 		= $customer->createdAt->timezone_type;
	// $custVals['timezone'] 			= $customer->createdAt->timezone;
	// $custVals['customFields'] 		= $customer->customFields;

	// below this will all be array values
	$custVals['creditCards'] 		= $customer->creditCards;
	$custVals['addresses'] 			= $customer->addresses;
	$custVals['coinbaseAccounts']	= $customer->coinbaseAccounts;
	$custVals['paypalAccounts'] 	= $customer->paypalAccounts;
	$custVals['applePayCards'] 		= $customer->applePayCards;

	// show the form
	showForm($custVals);
}
?>
<script src="../js/btScript.js"></script>
<?php
showBTFooter();
?>
