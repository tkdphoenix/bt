<?php
session_start();
defined("DS")? null : require_once(realpath(dirname(__FILE__) . DIRECTORY_SEPARATOR . "..") . DIRECTORY_SEPARATOR . "inc" . DIRECTORY_SEPARATOR . "initialize.php");

require_once(LIB_PATH . DS . "inc" . DS . "common.inc.php");
require_once(LIB_PATH . DS . "btVars.php");
// create the clientToken
$clientToken = Braintree_ClientToken::generate();
function showForm($errorsArr=[]){
	if(!empty($errorsArr)){
		foreach($errorsArr as $errMsg){
			echo "<p class='alert alert-danger'>". $errMsg ."</p>";
		}
	}
?>
	<div class="col-md-7">
		<div class="row">
			<div class="col-md-12">
				<form id="newCustForm" action="?" method="post" class="form-horizontal">
					<h3>Customer Details</h3>
					<div class="form-group">
						<label for="first" class="col-md-3 control-label">First Name</label>
						<div class="col-md-9">
							<input type="text" id="first" class="form-control" name="first" value="<?php echo (isset($_POST['first']))? $_POST['first']: ''; ?>" required>
						</div>
					</div>
					
					<div class="form-group">
						<label for="last" class="col-md-3 control-label">Last Name</label>
						<div class="col-md-9">
							<input type="text" id="last" class="form-control" name="last" value="<?php echo (isset($_POST['last']))? $_POST['last']: ''; ?>" required>
						</div>
					</div>
					
					<div class="form-group">
						<label for="company" class="col-md-3 control-label">Company</label>
						<div class="col-md-9">
							<input type="text" id="company" class="form-control" name="company" value="<?php echo (isset($_POST['company']))? $_POST['company']: ''; ?>">
						</div>
					</div>
					
					<div class="form-group">
						<label for="email" class="col-md-3 control-label">Email </label>
						<div class="col-md-9">
							<input type="email" id="email" class="form-control" name="email" value="<?php echo (isset($_POST['email']))? $_POST['email']: ''; ?>" required>
						</div>
					</div>
					
					<div class="form-group">
						<label for="phone" class="col-md-3 control-label">Phone </label>
						<div class="col-md-9">
							<input type="tel" id="phone" class="form-control" name="phone" value="<?php echo (isset($_POST['phone']))? $_POST['phone']: ''; ?>" required>
						</div>
					</div>

					<div class="form-group">
						<label for="fax" class="col-md-3 control-label">Fax </label>
						<div class="col-md-9">
							<input type="tel" id="fax" class="form-control" name="fax" value="<?php echo (isset($_POST['fax']))? $_POST['fax']: ''; ?>">
						</div>
					</div>

					<div class="form-group">
						<label for="website" class="col-md-3 control-label">Website </label>
						<div class="col-md-9">
							<input type="url" id="website" class="form-control" name="website" value="<?php echo (isset($_POST['website']))? $_POST['website']: ''; ?>">
						</div>
					</div>

					<div class="form-group">
						<div class="row">
							<div class="col-md-3 smallLabel">A random ID will be generated for you if you leave this blank</div>
							<div class="col-md-9"></div>
						</div>
						<label for="customerId" class="col-md-3 control-label">Customer ID</label>
						<div class="col-md-9">
							<input type="text" id="customerId" class="form-control" name="customerId" value="<?php echo (isset($_POST['customerId']))? $_POST['customerId']: ''; ?>">
						</div>
					</div> <!-- end main form-group -->


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
						
					<div id="paymentMethodDetails" class="paymentMethodDetails">
						<div class="form-group">
							<label for="cardholderName" class="col-md-2 control-label">Cardholder Name</label>
							<div class="col-md-2">
								<input type="text" class="form-control" name="cardholderName" value="<?php echo (isset($_POST['cardholderName']))? $_POST['cardholderName']: ''; ?>" placeholder="First Last">
							</div>
						
							<label for="number" class="col-md-2 control-label">Credit Card Number</label>
							<div class="col-md-3">
								<!-- <input id="number" type="text" class="form-control" name="number" value="<?php echo (isset($_POST['number']))? $_POST['number']: ''; ?>" placeholder="Credit Card Number"> -->
								<input id="number" type="text" class="form-control" data-braintree-name="number" placeholder="Credit Card Number">
							</div>
						</div>

						<div class="form-group">	
							<label for="expirationMonth" class="col-md-2 control-label">Expiration Date (MM/YY)</label>
							<div class="col-md-2">
								<!-- <input id="expirationDate" type="text" class="form-control" name="expirationDate" value="<?php echo (isset($_POST['expirationDate']))? $_POST['expirationDate']: ''; ?>" placeholder="Expiration Date (MM/YYYY)"> -->
								<input id="expirationDate" type="text" class="form-control" data-braintree-name="expiration_date" placeholder="Expiration Date (MM/YYYY)">
							</div>

							<label for="token" class="col-md-2 control-label">Payment Method Token (optional)</label>
							<div class="col-md-2">
								<input type="text" class="form-control" name="token" value="<?php echo (isset($_POST['token']))? $_POST['token']: ''; ?>" placeholder="Payment Method Token">
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
								<input type="text" class="form-control" name="billing_firstName" value="<?php echo (isset($_POST['billing_firstName']))? $_POST['billing_firstName']: ''; ?>" placeholder="First Name">
							</div>
						</div>
						
						<div class="form-group">
							<label for="lastName" class="col-md-3 control-label">Last Name</label>
							<div class="col-md-9">
								<input type="text" class="form-control" name="billing_lastName" value="<?php echo (isset($_POST['billing_lastName']))? $_POST['billing_lastName']: ''; ?>" placeholder="Last Name">
							</div>
						</div>
						
						<div class="form-group">
							<label for="company" class="col-md-3 control-label">Company</label>
							<div class="col-md-9">
								<input type="text" class="form-control" name="billing_company" value="<?php echo (isset($_POST['billing_company']))? $_POST['billing_company']: ''; ?>" placeholder="Company">
							</div>
						</div>
						
						<div class="form-group">
							<label for="streetAddress" class="col-md-3 control-label">Street Address</label>
							<div class="col-md-9">
								<input type="text" class="form-control" name="streetAddress" value="<?php echo (isset($_POST['streetAddress']))? $_POST['streetAddress']: ''; ?>" placeholder="Street Address">
							</div>
						</div>
						
						<div class="form-group">
							<label for="extendedAddress" class="col-md-3 control-label">Address 2</label>
							<div class="col-md-9">
								<input type="text" class="form-control" name="extendedAddress" value="<?php echo (isset($_POST['extendedAddress']))? $_POST['extendedAddress']: ''; ?>" placeholder="Address 2">
							</div>
						</div>
						
						<div class="form-group">
							<label for="locality" class="col-md-3 control-label">City</label>
							<div class="col-md-9">
								<input type="text" class="form-control" name="locality" value="<?php echo (isset($_POST['locality']))? $_POST['locality']: ''; ?>" placeholder="City">
							</div>
						</div>
						
						<div class="form-group">
							<label for="region" class="col-md-3 control-label">State / Province (Region)</label>
							<div class="col-md-9">
								<input type="text" class="form-control" name="region" value="<?php echo (isset($_POST['region']))? $_POST['region']: ''; ?>" placeholder="State / Province (Region)">
							</div>
						</div>
						
						<div class="form-group">
							<label for="postalCode" class="col-md-3 control-label">Postal Code</label>
							<div class="col-md-9">
								<input type="num" class="form-control" name="postalCode" value="<?php echo (isset($_POST['postalCode']))? $_POST['postalCode']: ''; ?>" placeholder="Postal Code">
							</div>
						</div>
						
						<div class="form-group">
							<label for="countryName" class="col-md-3 control-label">Country Name</label>
							<div class="col-md-9">
								<?php include("../inc/countries.inc.php"); ?>
							</div>
						</div>
					</div> <!-- end .billingAddressDetails -->
					
					<input class="btn greenBtn" type="submit" name="newCustSubmit" value="Create Customer">
				</form>
			</div>
		</div>
	</div>
<?php
} // end showForm()

// @TODO validate values on the server side and the client side

if(isset($_POST['newCustSubmit'])){ // if the form has been submitted
	showBTHeader("Add New Customer", "Add New Customer");
	showBTLeftNav();
	$errorsArr = [];
	$nonce = $_SESSION['nonce'];

	$customerDetails = array(
		"firstName"			=> $_POST['first'],
		"lastName"			=> $_POST['last'],
		"company"			=> $_POST['company'],
		"email"				=> $_POST['email'],
		"phone"				=> $_POST['phone'],
		"fax"				=> $_POST['fax'],
		"website"			=> $_POST['website']
	);

	// This can be set dynamically from BT, so it does not have to be passed
	if(!empty($_POST['customerId'])){
		$customerDetails["id"] = $_POST['customerId'];
	}

	// @TODO validate values on the server side and the client side
	// if a payment method has been chosen, create payment method
	if($_POST['withPmtMethodRadio'] === "true"){ // if payment method details are submitted, set those variables

		$customerDetails['paymentMethodNonce'] = $nonce;
	}

	// @TODO validate values on the server side and the client side
	// if a billing address has been chosen, create a billing address
	if($_POST['withBillingAddressRadio'] === "true"){
		$customerDetails["billingAddress"] = array(
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
	}
?>
	<div class="col-md-7">
		<div class="row">
			<div class="col-md-12">
<?php
	// @TODO validate values on the server side and the client side
	// once values are validated, submit the new customer to be inserted into BT
	// create the customer, then you can use the $result->id to create a payment method relating to that customer
	try{
		$result = Braintree_Customer::create($customerDetails);
		if ($result->success) {
		    echo $result->customer->id ."<br>";
		    echo $result->customer->paymentMethods[0]->token;
		    // @TODO may move output section from ln 312 to here.
		    // @TODO need to add section to show payment method billing address if created
		} else {
			echo "<br>Customer NOT created!<br>";

			foreach($result->errors->deepAll() as $error){
				file_put_contents($pathToBTErrorLog, timeNow() . " MST - createCustomer.php page\r\n" . $error->code .": ". $error->message, FILE_APPEND);
				throw new Exception($error->message, $error->code);
			}
		}
	} catch(Exception $e){
		// @TODO need to handle multiple errors
		echo "<p>Error: ". $e->getCode() ." - ". $e->getMessage() ."\r\nLine: ". $e->getLine() ."File: ". $e->getFile() ."</p>";
	}

	if(isset($result->success)){

		$customerId = $result->customer->id;
	?>
		<div class="col-md-7">
			<div class="row">
				<div class="col-md-12">
					<h3>Your Customer has been created</h3>
					<p>ID: <?=$result->customer->id?></p>
					<p>First Name: <?=$result->customer->firstName?></p>
					<p>Last Name: <?=$result->customer->lastName?></p>
					<p>Company: <?=$result->customer->company?></p>
					<p>Email: <?=$result->customer->email?></p>
					<p>Phone: <?=$result->customer->phone?></p>
					<p>Fax: <?=$result->customer->fax?></p>
					<p>Website: <?=$result->customer->website?></p>
				</div>
			</div>
	<?php
		if(!empty($result->customer->paymentMethods[0]->token)){
	?>
		<div class="row">
			<div class="col-md-12">
				<p>Payment Method: <?=$result->customer->paymentMethods[0]->token?></p>
			</div>
		</div>
	<?php
	// @TODO need to add section to show payment method billing address if created
		} else {
			echo "No payment method.";
		}
	?>
		<div class="row">
			<div class="col-md-12">
				<a id='another' class='btn greenBtn' href='createCustomer.php'>Create another customer</a>
			</div>
		</div>
	</div>
	<?php
	}
} else { // the form has not been submitted, so display the form
	showBTHeader("Create Customer", "Create Customer");
	showBTLeftNav();
	showForm();
}
?>
<script src="https://js.braintreegateway.com/js/braintree-2.22.2.min.js"></script>
<script>
	$("document").ready(function(){
		// custom nonce prep
		// braintree.setup("<?=$clientToken?>", "custom", { id: "newCustForm" });
		$('#newCustForm').submit(function(event){
			// if the nonce hasn't been submitted, run ajax. Otherwise we have nonce, and the form can use .unbind() and submit the form itself

			var client = new braintree.api.Client({clientToken: "<?=$clientToken?>"});
			client.tokenizeCard({
				number: $('#number').val(),
				expirationDate: $('#expirationDate').val()
			}, function (err, nonce) {
				console.error(err);
				console.info("the Nonce: " + nonce);
				// call AJAX
				var data = {
					"action": nonce 
				};
				$.ajax({
					type: "POST",
					async: false,
					dataType: "json",
					url: "nonceHandler.php",
					data: data,
					success: function(data) {
						console.info("returned from ajax: " + data['nonce']); // for testing only
						$('form').submit();
					}
				}); // END $.ajax()
			}); // END client.tokenizeCard()
			return true; // for testing only
		}); // END $.submit()
	}); // END document.ready()
</script>
<script src="../js/btScript.js"></script>
<?php
showBTFooter();
?>
