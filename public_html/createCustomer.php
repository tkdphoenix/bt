<?php
session_start();
// prevent session hijacking
session_regenerate_id();

defined("DS")? null : require_once(realpath(dirname(__FILE__) . DIRECTORY_SEPARATOR . "..") . DIRECTORY_SEPARATOR . "inc" . DIRECTORY_SEPARATOR . "initialize.php");

require_once(LIB_PATH . DS . "btVars.php");
require_once(LIB_PATH . DS . "inc" . DS . "common.inc.php");
// create the clientToken
$clientToken = Braintree_ClientToken::generate();
function showForm($errorsArr=[]){
	if(!empty($errorsArr)){
		foreach($errorsArr as $errMsg){
			echo "<p class='alert alert-danger'>". $errMsg ."</p>";
		}
	}
	if(isset($_POST)){
		foreach($_POST as $key=>$val){
			$$key = strip_tags($_POST[$key]);
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
							<input type="text" id="first" class="form-control" name="first" value="<?php echo (isset($first))? $first: ''; ?>" required>
						</div>
					</div>
					
					<div class="form-group">
						<label for="last" class="col-md-3 control-label">Last Name</label>
						<div class="col-md-9">
							<input type="text" id="last" class="form-control" name="last" value="<?php echo (isset($last))? $last: ''; ?>" required>
						</div>
					</div>
					
					<div class="form-group">
						<label for="company" class="col-md-3 control-label">Company</label>
						<div class="col-md-9">
							<input type="text" id="company" class="form-control" name="company" value="<?php echo (isset($company))? $company: ''; ?>">
						</div>
					</div>
					
					<div class="form-group">
						<label for="email" class="col-md-3 control-label">Email </label>
						<div class="col-md-9">
							<input type="email" id="email" class="form-control" name="email" value="<?php echo (isset($email))? $email: ''; ?>" required>
						</div>
					</div>
					
					<div class="form-group">
						<label for="phone" class="col-md-3 control-label">Phone </label>
						<div class="col-md-9">
							<input type="tel" id="phone" class="form-control" name="phone" value="<?php echo (isset($phone))? $phone: ''; ?>" required>
						</div>
					</div>

					<div class="form-group">
						<label for="fax" class="col-md-3 control-label">Fax </label>
						<div class="col-md-9">
							<input type="tel" id="fax" class="form-control" name="fax" value="<?php echo (isset($fax))? $fax: ''; ?>">
						</div>
					</div>

					<div class="form-group">
						<label for="website" class="col-md-3 control-label">Website </label>
						<div class="col-md-9">
							<input type="url" id="website" class="form-control" name="website" value="<?php echo (isset($website))? $website: ''; ?>">
						</div>
					</div>

					<div class="form-group">
						<div class="row">
							<div class="col-md-3 smallLabel">A random ID will be generated for you if you leave this blank</div>
							<div class="col-md-9"></div>
						</div>
						<label for="customerId" class="col-md-3 control-label">Customer ID</label>
						<div class="col-md-9">
							<input type="text" id="customerId" class="form-control" name="customerId" value="<?php echo (isset($customerId))? $customerId: ''; ?>">
						</div>
					</div> <!-- END main form-group -->


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
					</div> <!-- END .radio -->
						
					<div id="paymentMethodDetails" class="paymentMethodDetails">
						<div id="pwpp" class="form-group"></div>
						<div class="form-group">
							<label for="cardholderName" class="col-md-2 control-label">Cardholder Name</label>
							<div class="col-md-4">
								<input type="text" class="form-control" name="cardholderName" value="<?php echo (isset($cardholderName))? $cardholderName: ''; ?>" placeholder="First Last">
							</div>
						
							<label for="cardNum" class="col-md-2 control-label">Credit Card Number</label>
							<div class="col-md-4">
								<div id="cardNum" class="form-control"></div>
							</div>
						</div>

						<div class="form-group">	
							<label for="expDate" class="col-md-2 control-label">Expiration Date (MM/YY)</label>
							<div class="col-md-4">
								<div id="expDate" class="form-control"></div>
							</div>

							<label for="cvv" class="col-md-2 control-label">CVV</label>
							<div class="col-md-2">
								<div id="cvv" class="form-control" name="cvv"></div>
							</div>
						</div>

						<div class="form-group">
							<label for="token" class="col-md-2 control-label">Payment Method Token (optional)</label>
							<div class="col-md-4">
								<input type="text" class="form-control" name="token" placeholder="Payment Method Token"> <!-- if used, this value sets the name of the payment method -->
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
					</div> <!-- END .paymentMethodDetails -->

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
					</div> <!-- END .radio -->


					<div class="billingAddressDetails">
						<!-- billing address info -->			
						<div class="form-group">
							<label for="firstName" class="col-md-3 control-label">First Name</label>
							<div class="col-md-9">
								<input type="text" class="form-control" name="billing_firstName" value="<?php echo (isset($billing_firstName))? $billing_firstName: ''; ?>" placeholder="First Name">
							</div>
						</div>
						
						<div class="form-group">
							<label for="lastName" class="col-md-3 control-label">Last Name</label>
							<div class="col-md-9">
								<input type="text" class="form-control" name="billing_lastName" value="<?php echo (isset($billing_lastName))? $billing_lastName: ''; ?>" placeholder="Last Name">
							</div>
						</div>
						
						<div class="form-group">
							<label for="company" class="col-md-3 control-label">Company</label>
							<div class="col-md-9">
								<input type="text" class="form-control" name="billing_company" value="<?php echo (isset($billing_company))? $billing_company: ''; ?>" placeholder="Company">
							</div>
						</div>
						
						<div class="form-group">
							<label for="streetAddress" class="col-md-3 control-label">Street Address</label>
							<div class="col-md-9">
								<input type="text" class="form-control" name="streetAddress" value="<?php echo (isset($streetAddress))? $streetAddress: ''; ?>" placeholder="Street Address">
							</div>
						</div>
						
						<div class="form-group">
							<label for="extendedAddress" class="col-md-3 control-label">Address 2</label>
							<div class="col-md-9">
								<input type="text" class="form-control" name="extendedAddress" value="<?php echo (isset($extendedAddress))? $extendedAddress: ''; ?>" placeholder="Address 2">
							</div>
						</div>
						
						<div class="form-group">
							<label for="locality" class="col-md-3 control-label">City</label>
							<div class="col-md-9">
								<input type="text" class="form-control" name="locality" value="<?php echo (isset($locality))? $locality: ''; ?>" placeholder="City">
							</div>
						</div>
						
						<div class="form-group">
							<label for="region" class="col-md-3 control-label">State / Province (Region)</label>
							<div class="col-md-9">
								<input type="text" class="form-control" name="region" value="<?php echo (isset($region))? $region: ''; ?>" placeholder="State / Province (Region)">
							</div>
						</div>
						
						<div class="form-group">
							<label for="postalCode" class="col-md-3 control-label">Postal Code</label>
							<div class="col-md-9">
								<input type="num" class="form-control" name="postalCode" value="<?php echo (isset($postalCode))? $postalCode: ''; ?>" placeholder="Postal Code">
							</div>
						</div>
						
						<div class="form-group">
							<label for="countryName" class="col-md-3 control-label">Country Name</label>
							<div class="col-md-9">
								<?php include("../inc/countries.inc.php"); ?>
							</div>
						</div>
					</div> <!-- END .billingAddressDetails -->
					
					<input class="btn greenBtn" type="submit" name="newCustSubmit" value="Create Customer">
				</form>
			</div>
		</div>
	</div>
<?php
} // END showForm()

// @TODO validate values on the server side and the client side

if(isset($_POST['payment_method_nonce'])){ // if the form has been submitted
	showBTHeader("Add New Customer", "Add New Customer");
	showBTLeftNav();
	$errorsArr = [];
	$nonce = strip_tags($_POST['payment_method_nonce']);

	$customerDetails = array( // sanitized here
		"firstName"			=> strip_tags($_POST['first']),
		"lastName"			=> strip_tags($_POST['last']),
		"company"			=> strip_tags($_POST['company']),
		"email"				=> strip_tags($_POST['email']),
		"phone"				=> strip_tags($_POST['phone']),
		"fax"				=> strip_tags($_POST['fax']),
		"website"			=> strip_tags($_POST['website'])
	);

	// This can be set dynamically from BT, so it does not have to be passed
	if(!empty($_POST['customerId'])){
		$customerDetails["id"] = strip_tags($_POST['customerId']);
	}

	// @TODO validate values on the server side and the client side
	// if a payment method has been chosen, create payment method
	if($_POST['withPmtMethodRadio'] === "true" && $_POST["withBillingAddressRadio"] === "false"){ // if payment method details are submitted, set those variables

		$customerDetails['paymentMethodNonce'] = $nonce;
	}

	// @TODO validate values on the server side and the client side
	// if a billing address has been chosen, create a billing address
	if($_POST["withPmtMethodRadio"] === "true" && $_POST['withBillingAddressRadio'] === "true"){
		$customerDetails["creditCard"] = array(
			"paymentMethodNonce"	=> $nonce, // value already sanitized
			"billingAddress" 		=> array(
				"firstName"			=> strip_tags($_POST['billing_firstName']),
				"lastName"			=> strip_tags($_POST['billing_lastName']),
				"company"			=> strip_tags($_POST['billing_company']),
				"streetAddress"		=> strip_tags($_POST['streetAddress']),
				"extendedAddress"	=> strip_tags($_POST['extendedAddress']),
				"locality"			=> strip_tags($_POST['locality']),
				"region"			=> strip_tags($_POST['region']),
				"postalCode"		=> strip_tags($_POST['postalCode']),
				"countryName"		=> strip_tags($_POST['country'])
			),
			"options"				=> array(
				"verifyCard"		=> true
			)
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
		    // echo $result->customer->id ."<br>";
		    // echo $result->customer->paymentMethods[0]->token;
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
<script src="https://js.braintreegateway.com/js/braintree-2.22.1.min.js"></script>
<script>
	$("document").ready(function(){
		// adding PWPP capability when creating a customer
		braintree.setup(
			"<?=$clientToken?>",
			"custom", 
			{
				id: 'newCustForm',
				paypal: {
					container: "pwpp",
					singleUse: false,
					locale: "en_us",
					enableShippingAddress: true
				},
				hostedFields: {
					number: {
						selector: "#cardNum",
						placeholder: "Card Number"
					},
					cvv: {
						selector: "#cvv",
						placeholder: "CVV"
					},
					expirationDate: {
						selector: "#expDate",
						placeholder: "Expiration Date"
					}
				},
				onPaymentMethodReceived: function(obj){
					var nonceInsert = "<input type='hidden' name='payment_method_nonce' value='"+ obj.nonce +"'>";
					$("[type='submit']").before(nonceInsert);
					var form = document.getElementById("newCustForm");
					HTMLFormElement.prototype.submit.call(form);
				}
			}
		); // END braintree.setup()
	}); // END document.ready()
</script>
<script src="../js/btScript.js"></script>
<?php
showBTFooter();
?>
