<?php

function showForm(){
?>
	<form action="?" method="post" class="form-horizontal">
		<label for="fname">First Name
			<input type="text" id="fname" name="fname" tabindex="10">
		</label>
		<label for="lname">Last Name
			<input type="text" id="lname" name="lname" tabindex="20">
		</label>

	</form>
<?php
}
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

?>