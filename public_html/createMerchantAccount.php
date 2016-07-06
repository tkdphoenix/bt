<?php
session_start();
// prevent session hijacking
session_regenerate_id();

defined("DS")? null : require_once(realpath(dirname(__FILE__) . DIRECTORY_SEPARATOR . "..") . DIRECTORY_SEPARATOR . "inc" . DIRECTORY_SEPARATOR . "initialize.php");

require_once(LIB_PATH . DS . "btVars.php");
require_once(LIB_PATH . DS . "inc" . DS . "common.inc.php");
require_once(LIB_PATH . DS . "inc" . DS . "MerchantAccount.inc.php");

$merchant = new MerchantAccount();
// $firstName = "Joel";
// $lastName = "Grissom";
// $result = $merchant->updateParam("firstName", $firstName, "individual");
// $result .= " ". $merchant->updateParam("lastName", $lastName, "individual");
// echo $result;
// $merchantAccountParams = [
//   'individual' => [
//     'firstName' => 'Jane',
//     'lastName' => 'Doe',
//     'email' => 'jane@14ladders.com',
//     'phone' => '5553334444',
//     'dateOfBirth' => '1981-11-19',
//     'ssn' => '456-45-4567',
//     'address' => [
//       'streetAddress' => '111 Main St',
//       'locality' => 'Chicago',
//       'region' => 'IL',
//       'postalCode' => '60622'
//     ]
//   ],
//   'business' => [
//     'legalName' => 'Jane\'s Ladders',
//     'dbaName' => 'Jane\'s Ladders',
//     'taxId' => '98-7654321',
//     'address' => [
//       'streetAddress' => '111 Main St',
//       'locality' => 'Chicago',
//       'region' => 'IL',
//       'postalCode' => '60622'
//     ]
//   ],
//   'funding' => [
//     'descriptor' => 'Blue Ladders',
//     'destination' => Braintree_MerchantAccount::FUNDING_DESTINATION_BANK,
//     'email' => 'funding@blueladders.com',
//     'mobilePhone' => '5555555555',
//     'accountNumber' => '1123581321',
//     'routingNumber' => '071101307'
//   ],
//   'tosAccepted' => true,
//   'masterMerchantAccountId' => "14ladders_marketplace",
//   'id' => "blue_ladders_store"
// ];
// $result = Braintree_MerchantAccount::create($merchantAccountParams);

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
	// 
?>
		<<div class="col-md-7">
			<div class="row">
				<div class="col-md-12">
					<form id="createSubMerchant" class="form-horizontal" action="<?php echo htmlspecialchars("?"); ?>" method="post" >
						<div class="form-group">
							<input type="text" name="firstName" value="<?php echo (isset($vals->firstName))? $vals->firstName : ''; ?>">
						</div>
						<div class="form-group">
							<input type="text" name="lastName" value="<?php echo (isset($vals->lastName))? $vals->lastName : ''; ?>">
						</div>
						<div class="form-group">
							<input type="email" name="individualEmail" value="<?php echo (isset($vals->individualEmail))? $vals->individualEmail : ''; ?>">
						</div>
						<div class="form-group">
							<input type="tel" name="individualPhone" value="<?php echo (isset($vals->individualPhone))? $vals->individualPhone : ''; ?>">
						</div>
						<div class="form-group">
							<input type="date" name="dateOfBirth" value="<?php echo (isset($vals->dateOfBirth))? $vals->dateOfBirth : ''; ?>">
						</div>
						<div class="form-group">
							<input type="text" name="ssn" value="<?php echo (isset($vals->ssn))? $vals->ssn : ''; ?>">
						</div>
						<div class="form-group">
							<input type="text" name="individualStreetAddress" value="<?php echo (isset($vals->individualStreetAddress))? $vals->individualStreetAddress : ''; ?>">
						</div>
						<div class="form-group">
							<input type="text" name="individualLocality" value="<?php echo (isset($vals->individualLocality))? $vals->individualLocality : ''; ?>">
						</div>
						

						<!-- @TODO insert select for state since Marketplace is US only -->
						<input type="text" name="individualRegion" value="<?php echo (isset($vals->individualRegion))? $vals->individualRegion : ''; ?>">


						<div class="form-group">
							<input type="number" name="individualPostalCode" value="<?php echo (isset($vals->individualPostalCode))? $vals->individualPostalCode : ''; ?>">
						</div>
						<div class="form-group">
							<input type="text" name="businessLegalName" value="<?php echo (isset($vals->businessLegalName))? $vals->businessLegalName : ''; ?>">
						</div>
						<div class="form-group">
							<input type="text" name="businessDbaName" value="<?php echo (isset($vals->businessDbaName))? $vals->businessDbaName : ''; ?>">
						</div>
						<div class="form-group">
							<input type="text" name="businessTaxId" value="<?php echo (isset($vals->businessTaxId))? $vals->businessTaxId : ''; ?>">
						</div>
						<div class="form-group">
							<input type="text" name="businessStreetAddress" value="<?php echo (isset($vals->businessStreetAddress))? $vals->businessStreetAddress : ''; ?>">
						</div>
						<div class="form-group">
							<input type="text" name="businessLocality" value="<?php echo (isset($vals->businessLocality))? $vals->businessLocality : ''; ?>">
						</div>


						<!-- @TODO insert select for state since Marketplace is US only -->
						<input type="text" name="businessRegion" value="<?php echo (isset($vals->businessRegion))? $vals->businessRegion : ''; ?>">
						

						<div class="form-group">
							<input type="number" name="businessPostalCode" value="<?php echo (isset($vals->businessPostalCode))? $vals->businessPostalCode : ''; ?>">
						</div>
						<div class="form-group">
							<input type="text" name="fundingDescriptor" value="<?php echo (isset($vals->fundingDescriptor))? $vals->fundingDescriptor : ''; ?>">
						</div>


						<!-- @TODO may be able to make this a drop down selection for simplicity -->
						<input type="text" name="fundingDestination" value="<?php echo (isset($vals->fundingDestination))? $vals->fundingDestination : ''; ?>">


						<div class="form-group">
							<input type="email" name="fundingEmail" value="<?php echo (isset($vals->fundingEmail))? $vals->fundingEmail : ''; ?>">
						</div>
						<div class="form-group">
							<input type="tel" name="fundingMobilePhone" value="<?php echo (isset($vals->fundingMobilePhone))? $vals->fundingMobilePhone : ''; ?>">
						</div>
						<div class="form-group">
							<input type="text" name="fundingAccountNumber" value="<?php echo (isset($vals->fundingAccountNumber))? $vals->fundingAccountNumber : ''; ?>">
						</div>
						<div class="form-group">
							<input type="text" name="fundingRoutingNumber" value="<?php echo (isset($vals->fundingRoutingNumber))? $vals->fundingRoutingNumber : ''; ?>">
						</div>
						<div class="form-group">
							<input type="chekbox" name="tos" value="<?php echo (isset($vals->tosAccepted))? 'checked' : ''; ?>">
						</div>
						
						<!-- @TODO will need to update this once multiple accounts are implemented for teammates -->
						<input type="hidden" name="masterMerchantAccountId" value="<?php echo (isset($vals->masterMerchantAccountId))? $vals->masterMerchantAccountId : ''; ?>">
						
						<div class="form-group">
							<input type="text" name="id" value="<?php echo (isset($vals->id))? $vals->id : ''; ?>">
						</div>
						<input class="btn greenBtn" type="submit" value="Submit New SubMerchant">
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
	
	// ========================================
	// REMEMBER to trim() $_POST values before filters are applied and spaces become encoded to "%20"
	// validation tests
	// validation filters: http://php.net/manual/en/filter.filters.validate.php
	// email
	filter_var($email, FILTER_VALIDATE_EMAIL);
	// booleans
	FILTER_VALIDATE_BOOLEAN // If FILTER_NULL_ON_FAILURE flag is set, FALSE is returned only for "0", "false", "off", "no", and "", and NULL is returned for all non-boolean values.

	// float and int
	FILTER_VALIDATE_FLOAT // flags: FILTER_FLAG_ALLOW_THOUSAND
	FILTER_VALIDATE_INT // flags: FILTER_FLAG_ALLOW_OCTAL and FILTER_FLAG_ALLOW_HEX
	// mac address
	FILTER_VALIDATE_MAC
	// validate regular expression
	FILTER_VALIDATE_REGEXP
	// url
	FILTER_VALIDATE_URL // flags: FILTER_FLAG_SCHEME_REQUIRED, FILTER_FLAG_HOST_REQUIRED, FILTER_FLAG_PATH_REQUIRED, FILTER_FLAG_QUERY_REQUIRED

	// IP address IPv4
	filter_var($ipAddress, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4);
	// IP address IPv6
	filter_var($ipAddress, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6);
	// No private range IP address IPv4
	filter_var($ipAddress, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_NO_PRIV_RANGE);

	// ===========================================================
	// all other flags will be listed separately
	// Sanitize filters: http://php.net/manual/en/filter.filters.sanitize.php
	FILTER_SANITIZE_EMAIL // Remove all characters except letters, digits and !#$%&'*+-=?^_`{|}~@.[].
	FILTER_SANITIZE_ENCODED
	FILTER_SANITIZE_NUMBER_FLOAT
	FILTER_SANITIZE_NUMBER_INT
	FILTER_SANITIZE_SPECIAL_CHARS
	FILTER_SANITIZE_FULL_SPECIAL_CHARS
	FILTER_SANITIZE_STRING // TOO strong. . . removes greater than and less than signs. Example: "not a tag < 5" becomes "not a tag"
	FILTER_SANITIZE_STRIPPED
	FILTER_SANITIZE_URL // Remove all characters except letters, digits and $-_.+!*'(),{}|\\^~[]`<>#%";/?:@&=.
	FILTER_UNSAFE_RAW
	// ==========================================================
	// Filter flags: http://php.net/manual/en/filter.filters.flags.php
	FILTER_FLAG_STRIP_LOW		// used with: FILTER_SANITIZE_ENCODED
	                     		// 			FILTER_SANITIZE_SPECIAL_CHARS
	                     		// 			FILTER_SANITIZE_STRING
	                     		// 			FILTER_UNSAFE_RAW - Strips characters that have a numerical value <32.

	FILTER_FLAG_STRIP_HIGH		// used with: FILTER_SANITIZE_ENCODED
	                      		// 			FILTER_SANITIZE_SPECIAL_CHARS
	                      		// 			FILTER_SANITIZE_STRING
	                      		// 			FILTER_UNSAFE_RAW - Strips characters that have a numerical value >127.

	FILTER_FLAG_STRIP_BACKTICK	// used with: FILTER_SANITIZE_ENCODED
	                          	// 			FILTER_SANITIZE_SPECIAL_CHARS
	                          	// 			FILTER_SANITIZE_STRING
	                          	// 			FILTER_UNSAFE_RAW

	FILTER_FLAG_ALLOW_FRACTION	// used with: FILTER_SANITIZE_NUMBER_FLOAT - Allows a period (.) as a fractional separator in numbers.

	FILTER_FLAG_ALLOW_THOUSAND	// used with: FILTER_SANITIZE_NUMBER_FLOAT
	                          	// 			FILTER_VALIDATE_FLOAT - Allows a comma (,) as a thousands separator in numbers.

	FILTER_FLAG_ALLOW_SCIENTIFIC	// used with: FILTER_SANITIZE_NUMBER_FLOAT - Allows an e or E for scientific notation in numbers.

	FILTER_FLAG_NO_ENCODE_QUOTES	// used with: FILTER_SANITIZE_STRING - 	If this flag is present, single (') and double (") quotes will not be encoded.

	FILTER_FLAG_ENCODE_LOW		// used with: FILTER_SANITIZE_ENCODED
	                      		// 			FILTER_SANITIZE_STRING
	                      		// 			FILTER_SANITIZE_RAW - Encodes same as FILTER_FLAG_STRIP_LOW

	FILTER_FLAG_ENCODE_HIGH		// used with: FILTER_SANITIZE_ENCODED
	                       		// 			FILTER_SANITIZE_SPECIAL_CHARS
	                       		// 			FILTER_SANITIZE_STRING
	                       		// 			FILTER_SANITIZE_RAW - Encodes same as FILTER_FLAG_STRIP_HIGH

	FILTER_FLAG_ENCODE_AMP		// used with: FILTER_SANITIZE_STRING
	                      		// 			FILTER_SANITIZE_RAW

	FILTER_NULL_ON_FAILURE		// used with: FILTER_VALIDATE_BOOLEAN - Returns NULL for unrecognized boolean values.

	FILTER_FLAG_ALLOW_OCTAL		// used with: FILTER_VALIDATE_INT - Regards inputs starting with a zero (0) as octal numbers. This only allows the succeeding digits to be 0-7.

	FILTER_FLAG_ALLOW_HEX		// used with: FILTER_VALIDATE_INT - Regards inputs starting with 0x or 0X as hexadecimal numbers. This only allows succeeding characters to be a-fA-F0-9.

	FILTER_FLAG_IPV4			// used with: FILTER_VALIDATE_IP

	FILTER_FLAG_IPV6			// used with: FILTER_VALIDATE_IP

	FILTER_FLAG_NO_PRIV_RANGE	// used with: FILTER_VALIDATE_IP

	FILTER_FLAG_NO_RES_RANGE	// used with: FILTER_VALIDATE_IP - Fails validation for the following reserved IPv4 ranges: 0.0.0.0/8, 169.254.0.0/16, 192.0.2.0/24 and 224.0.0.0/4. This flag does not apply to IPv6 addresses.

	FILTER_FLAG_SCHEME_REQUIRED // used with: FILTER_VALIDATE_URL - 




	// forcing data type
	// to an int - (int) $item
	// to a float - (float) $item
	
	// often it is necessary to get file contents from another site
	$contents = file_get_contents('http://en.wikipedia.org/wiki/Douglas_Adams');

	// search and replace <script>xxxx</script> with '<!--'
	// search and replace <a href="xxxx" xxx> with '[xxxx]'
	$phase2 = preg_replace(	array(	'#<script#',
									'#</script>#',
									'#<a href="(.*?)"(.*?)>#'),
							array(	'<!-- ',
									' -->',
									'<span style="font-size: 8pt; font-style: italics;">[$1]</span>',),
							$contents);

	// validate max length
	// here are the "rules" for minimum and maximum lengths for city names
	$minLenCityName = 1;
	$maxLenCityName = 128;

	foreach ($cityTest as $city) {
		if (strlen($city) > $maxLenCityName) {
			echo '<li><b style="color: red;">INVALID</b>: City Name Too Long! [' . substr($city, 0, 20) . ']' . PHP_EOL;
			echo '<br /><i>Must be no more than ' . $maxLenCityName . ' letters in length!</i></li>' . PHP_EOL;
		} elseif (strlen($city) < $minLenCityName) {
			echo '<li><b style="color: red;">INVALID</b>: City Name Too Short! [' . substr($city, 0, 20) . ']' . PHP_EOL;
			echo '<br /><i>Must be at at least ' . $minLenCityName . ' letter(s) in length!</i></li>' . PHP_EOL;
		} else {
			echo '<li><b style="color: green;">VALID</b> [' . $city . ']</li>' . PHP_EOL;
		}
	}
} else {
	showBTHeader("Create a New Merchant", "Create a New Merchant");
	showBTLeftNav();
	showForm();
}

?>