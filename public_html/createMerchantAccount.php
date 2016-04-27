<?php
	defined("DS")? null : require_once(realpath(dirname(__FILE__) . DIRECTORY_SEPARATOR . "..") . DIRECTORY_SEPARATOR . "inc" . DIRECTORY_SEPARATOR . "initialize.php");

	require_once(LIB_PATH . DS . "inc" . DS . "common.inc.php");
	require_once(LIB_PATH . DS . "btVars.php");
	function showForm(){
?>
		<div class="col-md-7">
			<div class="row">
				<div class="col-md-12">
					<form id="createMerchantForm" class="form-horizontal" action="?" method="post">
						<div class="form-group">
							<label for="fname" class="col-md-3 control-label">First Name</label>
							<div class="col-md-9">
								<input type="text" id="fname" class="form-control" name="fname" tabindex="10">
							</div>
						</div>
						<div class="form-group">
							<label for="lname" class="col-md-3 control-label">Last Name</label>
							<div class="col-md-9">
								<input type="text" id="lname" class="form-control" name="lname" tabindex="20">
							</div>
						</div>
						<div class="form-group">
							<label for="email" class="col-md-3 control-label">Email</label>
							<div class="col-md-9">
								<input type="text" id="email" class="form-control" name="email" tabindex="30">
							</div>
						</div>
						<div class="form-group">
							<label for="phone" class="col-md-3 control-label">Phone</label>
							<div class="col-md-9">
								<input type="text" id="phone" class="form-control" name="phone" tabindex="40">
							</div>
						</div>
						<div class="form-group">
							<label for="dob" class="col-md-3 control-label">Date of Birth</label>
							<div class="col-md-9">
								<input type="text" id="dob" class="form-control" name="dob" tabindex="50">
							</div>
						</div>				
						<div class="form-group">
							<label for="ssn" class="col-md-3 control-label">Social Security Number</label>
							<div class="col-md-9">
								<input type="text" id="ssn" class="form-control" name="ssn" tabindex="60">
							</div>
						</div>				
						<div class="form-group">
							<label for="addr1" class="col-md-3 control-label">Street Address</label>
							<div class="col-md-9">
								<input type="text" id="addr1" class="form-control" name="addr1" tabindex="70">
							</div>
						</div>
						<div class="form-group">
							<label for="locality" class="col-md-3 control-label">City / Locality</label>
							<div class="col-md-9">
								<input type="text" id="locality" class="form-control" name="locality" tabindex="80">
							</div>
						</div>
						<div class="form-group">
							<label for="region" class="col-md-3 control-label">State / Region</label>
							<div class="col-md-9">
								<input type="text" id="region" class="form-control" name="region" tabindex="90">
							</div>
						</div>
						<div class="form-group">
							<label for="postalCode" class="col-md-3 control-label">Postal Code</label>
							<div class="col-md-9">
								<input type="text" id="postalCode" class="form-control" name="postalCode" tabindex="100">
							</div>
						</div>
							<input type="submit" class="btn greenBtn" name="submit" value="Create New Merchant">
					</form>
				</div>
			</div>
		</div>
<?php
	}

	if(isset($_POST['submit'])){
		/* example from docs - https://developers.braintreepayments.com/reference/request/merchant-account/create/php
		$merchantAccountParams = [
		  'individual' => [
		    'firstName' => 'Jane',
		    'lastName' => 'Doe',
		    'email' => 'jane@14ladders.com',
		    'phone' => '5553334444',
		    'dateOfBirth' => '1981-11-19',
		    'ssn' => '456-45-4567',
		    'address' => [
		      'streetAddress' => '111 Main St',
		      'locality' => 'Chicago',
		      'region' => 'IL',
		      'postalCode' => '60622'
		    ]
		  ],
		  'business' => [
		    'legalName' => 'Jane\'s Ladders',
		    'dbaName' => 'Jane\'s Ladders',
		    'taxId' => '98-7654321',
		    'address' => [
		      'streetAddress' => '111 Main St',
		      'locality' => 'Chicago',
		      'region' => 'IL',
		      'postalCode' => '60622'
		    ]
		  ],
		  'funding' => [
		    'descriptor' => 'Blue Ladders',
		    'destination' => Braintree_MerchantAccount::FUNDING_DESTINATION_BANK,
		    'email' => 'funding@blueladders.com',
		    'mobilePhone' => '5555555555',
		    'accountNumber' => '1123581321',
		    'routingNumber' => '071101307'
		  ],
		  'tosAccepted' => true,
		  'masterMerchantAccountId' => "14ladders_marketplace",
		  'id' => "blue_ladders_store"
		]
		$result = Braintree_MerchantAccount::create($merchantAccountParams);
		*/
	} else { // END if(isset($_POST['submit']))
		showBTHeader("Create a New Merchant", "Create a New Merchant");
		showBTLeftNav();
		showForm();
	} // END else


?>