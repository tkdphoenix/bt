<?php
	session_start();
	// prevent session hijacking
	session_regenerate_id();

	defined("DS")? null : require_once(realpath(dirname(__FILE__) . DIRECTORY_SEPARATOR . "..") . DIRECTORY_SEPARATOR . "inc" . DIRECTORY_SEPARATOR . "initialize.php");

	require_once(LIB_PATH . DS . "inc" . DS . "common.inc.php");
	require_once(LIB_PATH . DS . "btVars.php");
	
	// for looking up a specific merchant
	// $merchantAccount = Braintree_MerchantAccount::find($smID);

	function showForm($vals=NULL, $errors=NULL){
	?>
		<div class="col-md-7">
			<div class="row">
				<div class="col-md-12">
					<form id="updateSubMerchant" class="form-horizontal" action="<?php echo htmlspecialchars("?"); ?>" method="post" >
						<h2>Personal Information</h2>
						<div class="form-group">
							<label for="firstName">First Name</label>
							<input type="text" class="form-control" name="firstName" value="<?php echo (isset($vals->individual['firstName']))? $vals->individual['firstName'] : ''; ?>" placeholder="First Name">
						</div>
						<div class="form-group">
							<label for="lastName">Last Name</label>
							<input type="text" class="form-control" name="lastName" value="<?php echo (isset($vals->individual['lastName']))? $vals->individual['lastName'] : ''; ?>" placeholder="Last Name">
						</div>
						<div class="form-group">
							<label for="individualEmail">Email</label>
							<input type="email" class="form-control" name="individualEmail" value="<?php echo (isset($vals->individual['email']))? $vals->individual['email'] : ''; ?>" placeholder="Email">
						</div>
						<div class="form-group">
							<label for="individualPhone">Phone</label>
							<input type="tel" class="form-control" name="individualPhone" value="<?php echo (isset($vals->individual['phone']))? $vals->individual['phone'] : ''; ?>" placeholder="Phone">
						</div>
						<div class="form-group">
							<label for="dateOfBirth">Date of Birth</label>
							<input type="date" class="form-control" name="dateOfBirth" value="<?php echo (isset($vals->individual['dateOfBirth']))? $vals->individual['dateOfBirth'] : ''; ?>" placeholder="Date of Birth">
						</div>
						<div class="form-group">
							<label for="ssn">Social Security Number</label>
							<input type="text" class="form-control" name="ssn" value="<?php echo (isset($vals->individual['ssnLast4']))? $vals->individual['ssnLast4'] : ''; ?>" placeholder="Social Security Number">
						</div>
						<div class="form-group">
							<label for="individualStreetAddress">Street Address</label>
							<input type="text" class="form-control" name="individualStreetAddress" value="<?php echo (isset($vals->individual['address']['streetAddress']))? $vals->individual['address']['streetAddress'] : ''; ?>" placeholder="Street Address">
						</div>
						<div class="form-group">
							<label for="individualLocality">City</label>
							<input type="text" class="form-control" name="individualLocality" value="<?php echo (isset($vals->individual['address']['locality']))? $vals->individual['address']['locality'] : ''; ?>" placeholder="City">
						</div>

						<!-- select uses US States since Marketplace is US only -->
						<div class="form-group">
							<label for="individualR">State</label>
							<?php require_once(LIB_PATH . DS . "inc" . DS . "usStates.inc.php"); 
							usStates("individualRegion", $vals->individual['address']['region']);?>
						</div>
						<!-- <input type="text" name="individualRegion" value="<?php echo (isset($vals->individualRegion))? $vals->individualRegion : ''; ?>" placeholder="State"> -->

						<div class="form-group">
							<label for="individualPostalCode">Postal Code</label>
							<input type="number" class="form-control" name="individualPostalCode" value="<?php echo (isset($vals->individual['postalCode']))? $vals->individual['postalCode'] : ''; ?>" placeholder="Postal Code">
						</div>
						<h2>Business Information</h2>
						<div class="form-group">
							<label for="businessLegalName">Business Legal Name</label>
							<input type="text" class="form-control" name="businessLegalName" value="<?php echo (isset($vals->business['legalName']))? $vals->business['legalName'] : ''; ?>" placeholder="Business Legal Name">
						</div>
						<div class="form-group">
							<label for="dbaName">DBA Name</label>
							<input type="text" class="form-control" name="dbaName" value="<?php echo (isset($vals->business['dbaName']))? $vals->business['dbaName'] : ''; ?>" placeholder="DBA Name">
						</div>
						<div class="form-group">
							<label for="businessTaxId">Tax ID</label>
							<input type="text" class="form-control" name="businessTaxId" value="<?php echo (isset($vals->business['taxId']))? $vals->business['taxId'] : ''; ?>" placeholder="Tax ID (ex. 98-7654321)">
						</div>
						<div class="form-group">
							<label for="businessStr">Business Street Address</label>
							<input type="text" class="form-control" name="businessStreetAddress" value="<?php echo (isset($vals->business['address']['streetAddress']))? $vals->business['address']['streetAddress'] : ''; ?>" placeholder="Business Street Address">
						</div>
						<div class="form-group">
							<label for="businessLocality">City</label>
							<input type="text" class="form-control" name="businessLocality" value="<?php echo (isset($vals->business['address']['locality']))? $vals->business['address']['locality'] : ''; ?>" placeholder="City">
						</div>
						<div class="form-group">
							<label for="businessRegion">State</label>
							<?php require_once(LIB_PATH . DS . "inc" . DS . "usStates.inc.php");
							usStates("businessRegion", $vals->business['address']['region']);?>
						</div>
						<div class="form-group">
							<label for="businessPostalCode">Postal Code</label>
							<input type="number" class="form-control" name="businessPostalCode" value="<?php echo (isset($vals->business['address']['postalCode']))? $vals->business['address']['postalCode'] : ''; ?>" placeholder="Postal Code">
						</div>

						<h2>Funding Information</h2>
						<div class="form-group">
							<label for="fundingDescriptor">Funding Descriptor</label>
							<input type="text" class="form-control" name="fundingDescriptor" value="<?php echo (isset($vals->funding['descriptor']))? $vals->funding['descriptor'] : ''; ?>" placeholder="Funding Descriptor">
						</div>

						<div class="form-group">
							<label for="destination">Funding Destination</label>
							<select id="destination" class="form-control" name="destination">
								<option value="email" <?php echo ($vals->funding['destination'] == 'email')? "selected=\"selected\"" : ''; ?> >Email</option>
								<option value="mobile_phone" <?php echo ($vals->funding['destination'] == 'mobilePhone')? "selected=\"selected\"" : ''; ?> >Mobile Phone</option>
								<option value="bank" <?php echo ($vals->funding['destination'] == 'bank')? "selected=\"selected\"" : ''; ?> >Bank</option>
							</select>
							

							<!-- <input type="text" name="fundingDestination" value="<?php echo (isset($vals->fundingDestination))? $vals->fundingDestination : ''; ?>"> -->
							<!-- @TODO set onChange event to add text "If 'email' or 'mobile_phone', the sub-merchant must have or create a Venmo account to receive funds." Also, if bank is selected accountNumber and routingNumber are requred -->
						</div>

						<div class="form-group">
							<label for="fundingEmail">Email</label>
							<input type="email" class="form-control" name="fundingEmail" value="<?php echo ($vals->funding['email'])? $vals->funding['email'] : ''; ?>" placeholder="Email">
						</div>
						<div class="form-group">
							<label for="fundingMobilePhone">Mobile Phone</label>
							<input type="tel" class="form-control" name="fundingMobilePhone" value="<?php echo ($vals->funding['mobilePhone'])? $vals->funding['mobilePhone'] : ''; ?>" placeholder="Mobile Phone">
						</div>
						<div class="form-group">
							<label for="fundingAccountNumber">Account Number</label>
							<input type="text" class="form-control" name="fundingAccountNumber" value="<?php echo ($vals->funding['accountNumberLast4'])? $vals->funding['accountNumberLast4'] : ''; ?>" placeholder="Account Number">
						</div>
						<div class="form-group">
							<label for="fundingRoutingNumber">Routing Number</label>
							<input type="text" class="form-control" name="fundingRoutingNumber" value="<?php echo ($vals->funding['routingNumber'])? $vals->funding['routingNumber'] : ''; ?>" placeholder="Routing Number (ex. 114900685)">
						</div>
						
						<!-- @TODO will need to update this once multiple accounts are implemented for teammates -->
						<input type="hidden" name="masterMerchantAccountId" value="<?php echo ($vals->masterMerchantAccount->id)? $vals->masterMerchantAccount->id : ''; ?>">
						
						<div class="form-group">
							<input class="btn greenBtn" type="submit" name="updateSubmit" value="Update SubMerchant">
						</div>
						
					</form>
				</div>
			</div>
		</div>
	<?php
	} // END showForm()

	if(isset($_POST['updateSubmit'])){
		showBTHeader("Sub-Merchant Updated", "Sub-Merchant Updated");
		showBTLeftNav();
		
		// clean submitted values
		foreach($_POST as $key=>$val){
			$$key = strip_tags($val);
			echo "<p>". $key .": ". $$key ."</p>";
		}
	} else if(isset($_GET['id'])){
		$id = strip_tags($_GET['id']);
		$merchantAccount = Braintree_MerchantAccount::find($id);
		showBTHeader("Update Merchant", "Update Merchant $merchantAccount->id");
		showBTLeftNav();
		showForm($merchantAccount);
	} else {
		showBTHeader("Select a Sub-Merchant to Update", "Select a Sub-Merchant to Update");
		showBTLeftNav();
		$gateway = Braintree_configuration::gateway();
		// do find all
		$merchantAccountIterator = $gateway->merchantAccount()->all();
    ?>
	<div class="col-md-7">
		<div class="row">
			<div class="col-md-12">
				<table class="table table-hover submerchants">
					<thead>
						<tr>
							<td>Merchant Account ID</td>
							<td>Currency Code</td>
							<td>Status</td>
						</tr>
					</thead>
					<tbody>
	<?php
		foreach($merchantAccountIterator as $merchantAccount) {
		    // if account has master merchant account, get info and display it in the table
		    if(isset($merchantAccount->masterMerchantAccount)){
	?>
			<tr>
				<td><a class="subId" href="updateSubMerchantAccount.php?id=<?=$merchantAccount->id?>"><?=$merchantAccount->id?></a></td>
				<td><?=$merchantAccount->currencyIsoCode?></td>
				<td><?=$merchantAccount->status?></td>
			</tr>
	<?php
		    }
		} // END foreach
	?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<?php
	} // END else
	showBTFooter();

	// individual details
	// $result = Braintree_MerchantAccount::update(
	//   'blue_ladders_store',
	//   [
	//     'individual' => [
	//       'firstName' => 'Jane',
	//       'lastName' => 'Doe',
	//       'email' => 'jane@14ladders.com',
	//       'phone' => '5553334444',
	//       'dateOfBirth' => '1981-11-19',
	//       'ssn' => '456-45-4567',
	//       'address' => [
	//         'streetAddress' => '111 Main St',
	//         'locality' => 'Chicago',
	//         'region' => 'IL',
	//         'postalCode' => '60622'
	//       ]
	//     ]
	//   ]
	// );

	// $merchantAccount = $result->merchantAccount;
	// echo $merchantAccount->individualDetails->firstName;
	// // Jane
	
	// // business details
	// $result = Braintree_MerchantAccount::update(
	//   'blue_ladders_store',
	//   [
	//     'business' => [
	//       'legalName' => 'Jane\'s Ladders',
	//       'dbaName' => 'Jane\'s Ladders',
	//       'taxId' => '98-7654321',
	//       'address' => [
	//         'streetAddress' => '111 Main St',
	//         'locality' => 'Chicago',
	//         'region' => 'IL',
	//         'postalCode' => '60622'
	//       ]
	//     ]
	//   ]
	// );

	// $merchantAccount = $result->merchantAccount;
	// echo $merchantAccount->businessDetails->legalName;
	// // Jane's Ladders
	// echo $merchantAccount->businessDetails->taxId;
	// // 98-7654321
	

	// // funding details
	// $result = Braintree_MerchantAccount::update(
	//   'blue_ladders_store',
	//   [
	//     'funding' => [
	//       'descriptor' => 'Blue Ladders',
	//       'destination' => Braintree_MerchantAccount::FUNDING_DESTINATION_BANK,
	//       'email' => 'funding@blueladders.com',
	//       'mobilePhone' => '5555555555',
	//       'accountNumber' => '1123581321',
	//       'routingNumber' => '071101307'
	//       ]
	//   ]
	// );

	// $merchantAccount = $result->merchantAccount;
	// echo $merchantAccount->fundingDetails->accountNumberLast4;
	// // 1321
	// echo $merchantAccount->fundingDetails->routingNumber;
	// // 071101307