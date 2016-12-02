<?php
	session_start();
	// prevent session hijacking
	session_regenerate_id();

	defined("DS")? null : require_once(realpath(dirname(__FILE__) . DIRECTORY_SEPARATOR . "..") . DIRECTORY_SEPARATOR . "inc" . DIRECTORY_SEPARATOR . "initialize.php");

	require_once(LIB_PATH . DS . "inc" . DS . "common.inc.php");
	require_once(LIB_PATH . DS . "btVars.php");
	
	function showForm($vals=NULL, $errors=NULL){
		// individual phone is optional
		// ssn is optional
		// DBA name is optional
		// legal name AND tax_id are both required if EITHER is present
		// descriptor - If not provided, one will be generated based on the individual name, business legal name, or DBA name
		// destination - required, and the value can be "email", "mobile_phone", or "bank". If "email" or "mobile_phone", the sub-merchant must have or create a Venmo account to receive funds.
		// account_number and routing_number are required if destination is set to "bank". In this case, we'll deposit funds into the bank account associated with the provided account and routing numbers.
		// mobile_phone is required if destination is set to "mobile_phone". In this case, we'll deposit funds into the Venmo account associated with the provided phone number.
		// email is required if destination is set to "email". In this case, we'll deposit funds into the Venmo account associated with the provided email address.
		// @TODO - Add tos - "[MSP NAME] uses Braintree, a division of PayPal, Inc. (Braintree) for payment processing services. By using the Braintree payment processing services you agree to the Braintree Payment Services Agreement available at https://www.braintreepayments.com/legal/gateway-agreement, and the applicable bank agreement available at https://www.braintreepayments.com/legal/cea-wells ."
		// id is optional, but if not set, it will be generated automatically by Braintree and returned in the result object
	?>
			<div class="col-md-7">
				<div class="row">
					<div class="col-md-12">
						<form id="createSubMerchant" class="form-horizontal" action="<?php echo htmlspecialchars("?"); ?>" method="post" >
							<h2>Personal Information</h2>
							<div class="form-group">
								<label for="firstName">First Name</label>
								<input type="text" class="form-control" name="firstName" value="<?php echo (isset($vals->firstName))? $vals->firstName : ''; ?>" placeholder="First Name">
							</div>
							<div class="form-group">
								<label for="lastName">Last Name</label>
								<input type="text" class="form-control" name="lastName" value="<?php echo (isset($vals->lastName))? $vals->lastName : ''; ?>" placeholder="Last Name">
							</div>
							<div class="form-group">
								<label for="individualEmail">Email</label>
								<input type="email" class="form-control" name="individualEmail" value="<?php echo (isset($vals->individualEmail))? $vals->individualEmail : ''; ?>" placeholder="Email">
							</div>
							<div class="form-group">
								<label for="individualPhone">Phone</label>
								<input type="tel" class="form-control" name="individualPhone" value="<?php echo (isset($vals->individualPhone))? $vals->individualPhone : ''; ?>" placeholder="Phone">
							</div>
							<div class="form-group">
								<label for="dateOfBirth">Date of Birth</label>
								<input type="date" class="form-control" name="dateOfBirth" value="<?php echo (isset($vals->dateOfBirth))? $vals->dateOfBirth : ''; ?>" placeholder="Date of Birth">
							</div>
							<div class="form-group">
								<label for="ssn">Social Security Number</label>
								<input type="text" class="form-control" name="ssn" value="<?php echo (isset($vals->ssn))? $vals->ssn : ''; ?>" placeholder="Social Security Number">
							</div>
							<div class="form-group">
								<label for="individualStreetAddress">Street Address</label>
								<input type="text" class="form-control" name="individualStreetAddress" value="<?php echo (isset($vals->individualStreetAddress))? $vals->individualStreetAddress : ''; ?>" placeholder="Street Address">
							</div>
							<div class="form-group">
								<label for="individualLocality">City</label>
								<input type="text" class="form-control" name="individualLocality" value="<?php echo (isset($vals->individualLocality))? $vals->individualLocality : ''; ?>" placeholder="City">
							</div>

							<!-- select uses US States since Marketplace is US only -->
							<div class="form-group">
								<label for="individualR">State</label>
								<?php require_once(LIB_PATH . DS . "inc" . DS . "usStates.inc.php");
								usStates("individualRegion");?>
							</div>
							<!-- <input type="text" name="individualRegion" value="<?php echo (isset($vals->individualRegion))? $vals->individualRegion : ''; ?>" placeholder="State"> -->

							<div class="form-group">
								<label for="individualPostalCode">Postal Code</label>
								<input type="number" class="form-control" name="individualPostalCode" value="<?php echo (isset($vals->individualPostalCode))? $vals->individualPostalCode : ''; ?>" placeholder="Postal Code">
							</div>
							<h2>Business Information</h2>
							<div class="form-group">
								<label for="businessLegalName">Business Legal Name</label>
								<input type="text" class="form-control" name="businessLegalName" value="<?php echo (isset($vals->businessLegalName))? $vals->businessLegalName : ''; ?>" placeholder="Business Legal Name">
							</div>
							<div class="form-group">
								<label for="dbaName">DBA Name</label>
								<input type="text" class="form-control" name="dbaName" value="<?php echo (isset($vals->dbaName))? $vals->dbaName : ''; ?>" placeholder="DBA Name">
							</div>
							<div class="form-group">
								<label for="businessTaxId">Tax ID</label>
								<input type="text" class="form-control" name="businessTaxId" value="<?php echo (isset($vals->businessTaxId))? $vals->businessTaxId : ''; ?>" placeholder="Tax ID">
							</div>
							<div class="form-group">
								<label for="businessStr">Business Street Address</label>
								<input type="text" class="form-control" name="businessStreetAddress" value="<?php echo (isset($vals->businessStreetAddress))? $vals->businessStreetAddress : ''; ?>" placeholder="Business Street Address">
							</div>
							<div class="form-group">
								<label for="businessLocality">City</label>
								<input type="text" class="form-control" name="businessLocality" value="<?php echo (isset($vals->businessLocality))? $vals->businessLocality : ''; ?>" placeholder="City">
							</div>


							<!-- @TODO insert select for state since Marketplace is US only -->
							<div class="form-group">
								<label for="businessRegion">State</label>
								<?php require_once(LIB_PATH . DS . "inc" . DS . "usStates.inc.php");
								usStates("businessRegion");?>
							</div>
							<!-- <input type="text" class="form-control" name="businessRegion" value="<?php echo (isset($vals->businessRegion))? $vals->businessRegion : ''; ?>" placeholder="State"> -->
							
							<div class="form-group">
								<label for="businessPostalCode">Postal Code</label>
								<input type="number" class="form-control" name="businessPostalCode" value="<?php echo (isset($vals->businessPostalCode))? $vals->businessPostalCode : ''; ?>" placeholder="Postal Code">
							</div>

							<h2>Funding Information</h2>
							<div class="form-group">
								<label for="fundingDescriptor">Funding Descriptor</label>
								<input type="text" class="form-control" name="fundingDescriptor" value="<?php echo (isset($vals->fundingDescriptor))? $vals->fundingDescriptor : ''; ?>" placeholder="Funding Descriptor">
							</div>

							<div class="form-group">
								<label for="destination">Funding Destination</label>
								<select id="destination" class="form-control" name="destination" value="<?php echo (isset($vals->destination))? $vals->destination : ''; ?>">
									<option value="email">Email</option>
									<option value="mobile_phone">Mobile Phone</option>
									<option value="bank">Bank</option>
								</select>
								<!-- <input type="text" name="fundingDestination" value="<?php echo (isset($vals->fundingDestination))? $vals->fundingDestination : ''; ?>"> -->
								<!-- @TODO set onChange event to add text "If 'email' or 'mobile_phone', the sub-merchant must have or create a Venmo account to receive funds." Also, if bank is selected accountNumber and routingNumber are requred -->
							</div>

							<div class="form-group">
								<label for="fundingEmail">Email</label>
								<input type="email" class="form-control" name="fundingEmail" value="<?php echo (isset($vals->fundingEmail))? $vals->fundingEmail : ''; ?>" placeholder="Email">
							</div>
							<div class="form-group">
								<label for="fundingMobilePhone">Mobile Phone</label>
								<input type="tel" class="form-control" name="fundingMobilePhone" value="<?php echo (isset($vals->fundingMobilePhone))? $vals->fundingMobilePhone : ''; ?>" placeholder="Mobile Phone">
							</div>
							<div class="form-group">
								<label for="fundingAccountNumber">Account Number</label>
								<input type="text" class="form-control" name="fundingAccountNumber" value="<?php echo (isset($vals->fundingAccountNumber))? $vals->fundingAccountNumber : ''; ?>" placeholder="Account Number">
							</div>
							<div class="form-group">
								<label for="fundingRoutingNumber">Routing Number</label>
								<input type="text" class="form-control" name="fundingRoutingNumber" value="<?php echo (isset($vals->fundingRoutingNumber))? $vals->fundingRoutingNumber : ''; ?>" placeholder="Routing Number">
							</div>
							<div class="form-group">
								<label><input type="checkbox" name="tosAccepted" value="<?php echo (isset($vals->tosAccepted))? 'checked' : ''; ?>"> I accept the terms of service.</label>
							</div>
							
							<!-- @TODO will need to update this once multiple accounts are implemented for teammates -->
							<input type="hidden" name="masterMerchantAccountId" value="<?php echo (isset($vals->masterMerchantAccountId))? $vals->masterMerchantAccountId : ''; ?>">
							
							<div class="form-group">
								<label for="id">Preferred ID Name</label>
								<input type="text" class="form-control" name="id" value="<?php echo (isset($vals->id))? $vals->id : ''; ?>" placeholder="Preferred ID Name">
								<p>If you do not choose an ID one will be automatically generated for the Master Merchant to identify you.</p>
							</div>
							<div class="form-group">
								<input class="btn greenBtn" type="submit" name="createSubmit" value="Submit New SubMerchant">
							</div>
							
						</form>
					</div>
				</div>
			</div>
	<?php
	} // end showForm()

	if(isset($_POST['createSubmit'])){
		$firstName = strip_tags($_POST['firstName']);
		$lastName = strip_tags($_POST['lastName']);
		$individualEmail = strip_tags($_POST['individualEmail']);
		$individualPhone = strip_tags($_POST['individualPhone']);
		$dateOfBirth = strip_tags($_POST['dateOfBirth']);
		$ssn = strip_tags($_POST['ssn']);
		$individualStreetAddress = strip_tags($_POST['individualStreetAddress']);
		$individualLocality = strip_tags($_POST['individualLocality']);
		$individualRegion = strip_tags($_POST['individualRegion']);
		$individualPostalCode = strip_tags($_POST['individualPostalCode']);
		$businessLegalName = strip_tags($_POST['businessLegalName']);
		$dbaName = strip_tags($_POST['dbaName']);
		$businessTaxId = strip_tags($_POST['businessTaxId']);
		$businessStreetAddress = strip_tags($_POST['businessStreetAddress']);
		$businessLocality = strip_tags($_POST['businessLocality']);
		$businessRegion = strip_tags($_POST['businessRegion']);
		$businessPostalCode = strip_tags($_POST['businessPostalCode']);
		$fundingDescriptor = strip_tags($_POST['fundingDescriptor']);
		$destination = strip_tags($_POST['destination']);
		$fundingEmail = strip_tags($_POST['fundingEmail']);
		$fundingMobilePhone = strip_tags($_POST['fundingMobilePhone']);
		$fundingAccountNumber = strip_tags($_POST['fundingAccountNumber']);
		$fundingRoutingNumber = strip_tags($_POST['fundingRoutingNumber']);
		$tosAccepted = strip_tags($_POST['tosAccepted']);
		$masterMerchantAccountId = strip_tags($_POST['masterMerchantAccountId']);
		$id = strip_tags($_POST['id']);

		// @TODO - form validation - check for required fields
		showBTHeader("Creating Sub-Merchant", "Creating Sub-Merchant");
		showBTLeftNav();
		try{
			$merchantAccountParams = [
				'individual' => [
					'firstName' => $firstName,
					'lastName' => $lastName,
					'email' => $individualEmail,
					'phone' => $individualPhone,
					'dateOfBirth' => $dateOfBirth,
					'ssn' => $ssn,
					'address' => [
						'streetAddress' => $individualStreetAddress,
						'locality' => $individualLocality,
						'region' => $individualRegion,
						'postalCode' => $individualPostalCode
					]
				],
				'business' => [
					'legalName' => $businessLegalName,
					'dbaName' => $dbaName,
					'taxId' => $businessTaxId,
					'address' => [
						'streetAddress' => $businessStreetAddress,
						'locality' => $businessLocality,
						'region' => $businessRegion,
						'postalCode' => $businessPostalCode
					]
				],
				'funding' => [
					'descriptor' => $fundingDescriptor,
					'destination' => Braintree_MerchantAccount::FUNDING_DESTINATION_BANK,
					'email' => $fundingEmail,
					'mobilePhone' => $fundingMobilePhone,
					'accountNumber' => $fundingAccountNumber,
					'routingNumber' => $fundingRoutingNumber
				],
				'tosAccepted' => $tosAccepted,
				'masterMerchantAccountId' => "b9gndw43fy826hvc",
				'id' => "blue_ladders_store"
			];
			$result = Braintree_MerchantAccount::create($merchantAccountParams);

			if($result->success){
				// header and left nav are already on the page
?>
		<div class="col-md-7">
			<div class="row">
				<div class="col-md-12">
<?php
				print_r($result);
				// $txn = $result->transaction;

				// echo "<p>Your payment went through. You are the proud owner of a MacBook Pro 13&quot;! What a great deal!</p>";
				// echo "<h3>Transaction detaiils:</h3>";
				// echo "id = ". $txn->id ."</p>";
				// echo "<p>status = ". $txn->status ."</p>";
				// echo "<p>type = ". $txn->type ."</p>";
				// echo "<p>amount = ". $txn->amount ."</p>";
			} else {
				var_dump($result->errors->deepAll());
				throw new Exception("The transaction wasn't successful.");
			}
		} catch (Exception $e) {
			echo 'Caught exception: ',  $e->getMessage(), "\n";
		}

	} else {
		showBTHeader("Create a New Sub-Merchant", "Create a New Sub-Merchant");
		showBTLeftNav();
		showForm();
	}

?>