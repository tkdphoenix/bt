<?php
defined("DS")? null : require_once(realpath(dirname(__FILE__) . DIRECTORY_SEPARATOR . "..") . DIRECTORY_SEPARATOR . "inc" . DIRECTORY_SEPARATOR . "initialize.php");

require_once(LIB_PATH . DS . "btVars.php");
require_once(LIB_PATH . DS ."inc". DS ."common.inc.php");

function showForm(){
?>
		<div class="row">
			<div class="col-md-12">
				<p>Choose a subscription ID and the subscription details will be added to a form for you to update / change. You can only update Pending, Active, and Past Due subscriptions.</p>
				<form id="chooseSubscriptionForm" class="form-horizontal" method="post" action="<?php echo htmlspecialchars("?"); ?>">
					<div class="form-group">
						<label for="planNameBox" class="sr-only">Subscription ID</label>
						<input id="planNameBox" type="text" name="subscriptionId" aria-label="Subscription ID" placeholder="Subscription ID" tabindex="10">
						<input class="btn greenBtn" type="submit" name="subscriptionSubmit" aria-label="Subscription submit button" value="Submit">
					</div>
				</form>
			</div>
		</div>
<?php
} // END showForm()

function showUpdateForm($obj=NULL){
?>
		<div class="row">
			<div class="col-md-12">
				<form id="updateSubscriptionForm" class="form-horizontal" method="post" action="<?php echo htmlspecialchars("?"); ?>">
<?php
	$digit = 35; // to create different tabindex values
	if($obj->status == "Active" || $obj->status == "Pending"){
?>
						<div class="form-group">
							<label class="sr-only">Subscription ID </label>
							<input type="text" name="subscriptionId" tabindex="10" value="<?=$obj->id?>" aria-label="Subscription ID" placeholder="Subscription ID">
						</div>
						<div class="form-group">
							<label class="sr-only">Price </label>
							<input type="number" name="price" tabindex="10" value="<?=$obj->price?>" aria-label="Subscription Price" placeholder="Price">
						</div>
						<div class="form-group">
							<label class="sr-only">Plan ID </label>
							<input type="text" name="planId" tabindex="20" value="<?=$obj->planId?>" aria-label="Subscription Plan ID" placeholder="Subscription Plan ID">
						</div>
						<div class="form-group">
							<label class="sr-only">Payment Method </label>
							<input type="text" placeholder="Payment Method" name="pmtMethodToken" tabindex="30" value="<?=$obj->paymentMethodToken?>" aria-label="Payment Method" placeholder="Payment Method">
						</div>
						<div class="form-group">
							<label class="sr-only">Merchant Account ID </label>
							<input type="text" name="maid" tabindex="32" value="<?=$obj->merchantAccountId?>" aria-label="Merchant Account ID" placeholder="Merchant Account ID">
							</div>
						<!-- @TODO calculate fields for add-ons and discounts with conditionals -->
						<div class="form-group">
							<h4>Add Ons</h4>
						</div>
<?php
		if(!empty($obj->addOns)){
			$indexVal = 1; // to provide a numerical grouping for each discount or addOn (in case of multiples)
			foreach($obj->addOns as $addon){
?>
						<div class="form-group">
							<label class="sr-only">Update this add-on &ensp;
							<input type="radio" name="addOnHandler<?=$indexVal?>" aria-label="Update this add-on" value="updateAddOn" checked> &emsp;
							<label class="sr-only">Remove this add-on &ensp;</label>
							<input type="radio" name="addOnHandler<?=$indexVal?>" aria-label="Remove this add-on" value="removeAddOn"> &emsp;
						</div>
						<div class="form-group">
							<label class="sr-only">Add On <?=$indexVal?> Amount: </label>
							<input type="number" name="addOnAmt<?=$indexVal?>" tabindex="<?=$digit?>" value="<?=$addon->amount?>"><?php $digit++; ?>" aria-label="Add On <?=$indexVal?> Amount" placeholder="Add On <?=$indexVal?> Amount">
						</div>
						<div class="form-group">
							<label class="sr-only">Add On <?=$indexVal?> Current Billing Cycle: </label>
							<input type="text" name="addOnCurrBillCycle<?=$indexVal?>" tabindex="<?=$digit?>" value="<?=$addon->currentBillingCycle?>" aria-label="Add On <?=$indexVal?> Current Billing Cycle" placeholder="Add On <?=$indexVal?> Current Billing Cycle"><?php $digit++; ?>
						</div>
						<div class="form-group">
							<label class="sr-only">Add On <?=$indexVal?> ID: </label>
							<input type="text" placeholder="Add On ID" name="addOnId<?=$indexVal?>" tabindex="<?=$digit?>" value="<?=$addon->id?>" aria-label="Add On <?=$indexVal?> ID" placeholder="Add On <?=$indexVal?> ID"><?php $digit++; ?>
						</div>
						<div class="form-group">
							<label class="sr-only">Add On <?=$indexVal?> Name: </label>
							<input type="text" placeholder="Add On Name" name="addOnName<?=$indexVal?>" tabindex="<?=$digit?>" value="<?=$addon->name?>" aria-label="Add On <?=$indexVal?> Name" placeholder="Add On <?=$indexVal?> Name"><?php $digit++; ?>
						</div>
<?php
				// @TODO make "never expires" a checkbox
				if($addon->neverExpires == true ){
									echo "<div class='form-group'><label class='sr-only'>Add On {$indexVal} Never Expires: </label><input type='text' name='addOnNeverExpires{$indexVal}' tabindex='{$digit}' value='true' aria-label='Add On {$indexVal} Never Expires' placeholder='Add On {$indexVal} Never Expires'></div>"; $digit++;
				} elseif($addon->neverExpires == false){
									echo "<div class='form-group><label class='sr-only'>Add On {$indexVal} Never Expires: </label><input type='text' placeholder='Never Expires' name='addOnNeverExpires{$indexVal}' tabindex='{$digit}' value='false' aria-label='Add On {$indexVal} Never Expires' placeholder='Add On {$indexVal} Never Expires'></div>"; $digit++;
				}
?>
						<div class="form-group">
							<label class="sr-only">Add On <?=$indexVal?> Number of Billing Cycles: </label>
							<input type="number" name="addOnNumBillCycles<?=$indexVal?>" tabindex="<?=$digit?>" value="<?=$addon->numberOfBillingCycles?>" aria-label="Add On <?=$indexVal?> Number of Billing Cycles" placeholder="Add On <?=$indexVal?> Number of Billing Cycles"><?php $digit++; ?>
						</div>
						<div class="form-group">
							<label class="sr-only">Add On <?=$indexVal?> Quantity: </label>
								<input type="number" placeholder="Quantity" name="addOnQuantity<?=$indexVal?>" tabindex="<?=$digit?>" value="<?=$addon->quantity?>" aria-label="Add On <?=$indexVal?> Quantity" placeholder="Add On <?=$indexVal?> Quantity"><?php $digit++; ?>
						</div>
						<hr class="bt">
<?php
				$indexVal++;
			} // END foreach($obj->addOns as $addon)
		} else {
?>
						<div class="form-group">
							<p>There are no Add Ons for this subscription.</p>
						</div>
<?php
		}
?>
						<!-- Add an Add-On -->
						<div id="addAddOn" class="form-group addAnAddOn">
							<p>Add an Add-On to this subscription <span class="glyphicon glyphicon-plus-sign"></span></p>					
						</div>

						<div class="form-group">
							<h4>Discounts</h4>
						</div>
<?php
		if(!empty($obj->discounts)){
			$indexVal = 1; // to provide a numerical grouping for each discount or addOn (in case of multiples)
			foreach($obj->discounts as $discount){
?>
						<div class="form-group">
							<label>Update this discount &ensp;
								<input type="radio" name="discountHandler<?=$indexVal?>" aria-label="Update this discount" value="updateDiscount" checked> &emsp;
							</label>
							<label>Remove this discount &ensp;
								<input type="radio" name="discountHandler<?=$indexVal?>" aria-label="Remove this discount" value="removeDiscount"> &emsp;
							</label>
						</div>
						<div class="form-group">
							<label class="sr-only">Discount <?=$indexVal?> Amount: </label>
							<input type="number" placeholder="Amount" name="discountAmt<?=$indexVal?>" tabindex="<?=$digit?>" value="<?=$discount->amount?>" aria-label="zzz" placeholder="zzz"><?php $digit++; ?>
						</div>
						<div class="form-group">
							<label class="sr-only">Discount <?=$indexVal?> Current Billing Cycle: </label>
							<input type="text" placeholder="Current Billing Cycle" name="discountCurrBillCycle<?=$indexVal?>" tabindex="<?=$digit?>" value="<?=$discount->currentBillingCycle?>" aria-label="zzz" placeholder="zzz"><?php $digit++; ?>
						</div>
						<div class="form-group">
							<label class="sr-only">Discunt <?=$indexVal?> ID: </label>
							<input type="text" placeholder="Discount ID" name="discountId<?=$indexVal?>" tabindex="<?=$digit?>" value="<?=$discount->id?>" aria-label="zzz" placeholder="zzz"><?php $digit++; ?>
						</div>
						<div class="form-group">
							<label class="sr-only">Discount <?=$indexVal?> Name: </label>
							<input type="text" placeholder="Discount Name" name="discountName<?=$indexVal?>" tabindex="<?=$digit?>" value="<?=$discount->name?>" aria-label="zzz" placeholder="zzz"><?php $digit++; ?>
						</div>
<?php
				// @TODO set the "never expires" value as a checkbox
				if($discount->neverExpires == true ){
									echo "<div class='form-group'><label class='sr-only'>Discount {$indexVal} Never Expires: </label><input type='text' placeholder='Never Expires' name='discountNeverExpires{$indexVal}' tabindex='{$digit}' value='true' aria-label='Discount Never Expires{$indexVal}'></div>"; $digit++;
				} elseif($discount->neverExpires == false){
									echo "<div class='form-group'><label class='sr-only'>Discount {$indexVal} Never Expires: <input type='text' placeholder='Never Expires' name='discountNeverExpires{$indexVal}' tabindex='{$digit}' value='false' aria-label='Discount Never Expires{$indexVal}'></div>"; $digit++;
				}
?>
						<div class="form-group">
							<label class="sr-only">Discount <?=$indexVal?> Number of Billing Cycles: </label>
							<input type="number" name="discountNumBillCycles<?=$indexVal?>" tabindex="<?=$digit?>" value="<?=$discount->numberOfBillingCycles?>" aria-label="Number of Billing Cycles" placeholder="Number of Billing Cycles"><?php $digit++; ?>
						</div>
						<div class="form-group">
							<label>Discount <?=$indexVal?> Quantity: </label>
							<input type="number" name="discountQuantity<?=$indexVal?>" tabindex="<?=$digit?>" value="<?=$discount->quantity?>" aria-label="Discount <?=$indexVal?> Quantity" placeholder="Discount <?=$indexVal?> Quantity"><?php $digit++; ?>
						</div>
						<hr class="bt">
<?php
				$indexVal++;
			}
		} else {
?>
						<div class="form-group">
							<p>There are no Discounts for this subscription.</p>
						</div>
<?php
		}
?>
						<!-- Add a Discount -->
						<div id="addDiscount" class="form-group addADiscount">
							<p>Add a Discount to this subscription <span class="glyphicon glyphicon-plus-sign"></span></p>
						</div>

						<!-- descriptor is multi-field object - name, phone, url -->
						<div class="form-group">
							<h4>Descriptor Fields</h4>
						</div>
<?php
		if(!is_null($obj->descriptor->name)){
			foreach($obj->descriptor as $descrip){
?>
						<div class="form-group">
							<label class="sr-only">Descriptor Name
							<input type="text" name="descripName" tabindex="<?=$digit?>" value="<?=$descrip['name']?>" aria-label="Descriptor Name" placeholder="Descriptor Name"><?php $digit++; ?>
						</div>
						<div class="form-group">
							<label>Descriptor Phone</label>
							<input type="tel" name="descripPhone" tabindex="<?=$digit?>" value="<?=$descrip['phone']?>" aria-label="Descriptor Phone" placeholder="Descriptor Phone"><?php $digit++; ?>
						</div>
						<div class="form-group">
							<label class="sr-only">Descriptor URL</label>
							<input type="url" name="descripUrl" tabindex="<?=$digit?>" value="<?=$descrip['url']?>" aria-label="Descriptor URL" placeholder="Descriptor URL"><?php $digit++; ?>
						</div>
<?php
			}
		} else { // there are no descriptor fields
?>
						<div class="form-group">
							<p>There are no descriptor fields for this subscription.</p>
						</div>
<?php
		}
	// for past due statuses
	} elseif($obj->status == "Past Due") {
?>
					<div class="form-group">
						<label class="sr-only">Subscription ID</label>
						<input type="text" name="subscriptionId" tabindex="10" value="<?=$obj->id?>" aria-label="Subscription ID" placeholder="Subscription ID">
					</div>
					<div class="form-group">
						<label class="sr-only">Payment Method</label>
						<input type="text" name="value="<?=$obj->id?>" aria-label="Payment Method" placeholder="Payment Method">
					</div>
					<div class="form-group">
					<?php // @TODO gather this from user login when available ?>
						<label class="sr-only">Merchant Account</label>
						<input type="text" placeholder="Merchant Account" name="maid" tabindex="30" value="<?=$obj->id?>" aria-label="Merchant Account" placeholder="Merchant Account">
					</div>
<?php
	foreach($obj->descriptor as $descrip){
?>
					<div class="form-group">
						<label class="sr-only">Descriptor Name</label>
						<input type="text" name="descripName" tabindex="<?=$digit?>" value="<?=$descrip['name']?>" aria-label="Descriptor Name" placeholder="Descriptor Name"><?php $digit++; ?>
					</div>
					<div class="form-group">
						<label class="sr-only">Descriptor Phone</label>
						<input type="tel" name="descripPhone" tabindex="<?=$digit?>" value="<?=$descrip['phone']?>" aria-label="Descriptor Phone" placeholder="Descriptor Phone"><?php $digit++; ?>
					</div>
					<div class="form-group">
						<label class="sr-only">Descriptor URL</label>
						<input type="url" name="descripUrl" tabindex="<?=$digit?>" value="<?=$descrip['url']?>" aria-label="Descriptor URL" placeholder="Descriptor URL"><?php $digit++; ?>
					</div>
<?php
	} // END foreach 
} // END elseif($obj->status == "Past Due")
?>
					<input class="btn greenBtn" type="submit" name="updateSubmit" aria-label="Submit button" value="Submit" tabindex="150">
				</form>
			</div>
		</div>
<?php
} // END showUpdateForm()

if(isset($_POST['subscriptionSubmit'])){ // if the choose subscription form was submitted
	// strip tags from variables passed in
	$subscriptionId = strip_tags($_POST['subscriptionId']);
	$subscription = Braintree_Subscription::find($subscriptionId);
	showBTHeader("Update Subscription", "Update the Selected Subscription");
	showBTLeftNav();
?>
		<div class="col-md-10">
			<p>You can only update select fields in a subscription. Remember that updating a subscription does not update a plan. It <i>only</i> updates for the one subscription.</p>
			<?php showUpdateForm($subscription); ?>
		</div>

		<script>
			var initAddOnVal = 1;
			var initDiscountVal = 1;
			$("#updateSubscriptionForm").on('click', '.glyphicon-plus-sign', function(){
				var thisBtn = $(this);
				// check if it is an add-on or discount
				if(thisBtn.parent().parent().hasClass("addAnAddOn")){
					console.info("add on");
					var addOnFields = "<section class='newAddOn'><div class='form-group'>New Add On"+ 
					  "<br><input class='col-md-5' type='number' name='newAddOnAmount"+ initAddOnVal +"' aria-label='Add-On Amount' placeholder='Add-On Amount'></div>" +
					  "<div class='form-group'><input class='col-md-5' type='text' name='newAddOnInheritedFromId" + initAddOnVal + "' aria-label='ID (This add-on ID must already exist in your account)' placeholder='ID (This add-on ID must already exist in your account)'></div>" +
					  // @TODO make this field a checkbox for "never expires"
					  "<div class='form-group'><input class='col-md-5' type='text' name='newAddOnNeverExpires"+ initAddOnVal +"' aria-label='Never Expires (should be true or false)' placeholder='Never Expires (should be true or false)'></div>" +
					  "<div class='form-group'><input class='col-md-5' type='number' name='newAddOnNumberOfBillingCycles"+ initAddOnVal +"' aria-label='Number of Billing Cycles' placeholder='Number of Billing Cycles'></div>" +
					  "<div class='form-group'><input class='col-md-5' type='number' name='newAddOnQuantity"+ initAddOnVal +"' aria-label='Quantity' placeholder='Quantity'></div>" +
					  "<div class='form-group'>Cancel this Add-On <span class='glyphicon glyphicon-minus-sign' aria-hidden='true'></span></div>" +
					  "<hr class='bt'></section>";
					$(addOnFields).insertBefore(thisBtn.parent());

					initAddOnVal++;
				} else if(thisBtn.parent().parent().hasClass("addADiscount")){
					console.info("discount");
					var discountFields = "<section class='newDiscount'><div class='form-group'>New Discount"+ 
					  "<br><input class='col-md-5' type='number' name='newDiscountAmount"+ initDiscountVal +"' aria-label='New Discount Amount' placeholder='New Discount Amount'></div>" +
					  "<div class='form-group'><input class='col-md-5' type='text' name='newDiscountInheritedFromId"+ initDiscountVal +"' aria-label='Discount ID (This Discount ID must already exist in your account' placeholder='Discount ID (This Discount ID must already exist in your account'> &nbsp; <span class='red'>*</span></div>" +
					  // @TODO make "never expires" into a checkbox
					  "<div class='form-group'><p><input class='col-md-5' type='text' name='newDiscountNeverExpires"+ initDiscountVal +"' aria-label='Never Expires (should be true or false)' placeholder='Never Expires (should be true or false)'></div>" +
					  "<div class='form-group'><input class='col-md-5' type='number' name='newDiscountNumberOfBillingCycles"+ initDiscountVal +"' aria-label='Number of Billing Cycles' placeholder='Number of Billing Cycles'></div>" +
					  "<div class='form-group'><input class='col-md-5' type='number' name='newDiscountQuantity"+ initDiscountVal +"' aria-label='Discount Quantity' placeholder='Discount Quantity'></div>" +
					  "<div class='form-group'>Cancel this Discount <span class='glyphicon glyphicon-minus-sign aria-hidden='true'></span></div>" +
					  "<hr class='bt'></section>";
					$(discountFields).insertBefore(thisBtn.parent().parent());
					initDiscountVal++;
				}
			});

			// remove new add-on / discount
			$("#updateSubscriptionForm").on('click', '.glyphicon-minus-sign', function(){
				var thisRemoveBtn = $(this);
				thisRemoveBtn.closest("section").remove();
			});
		</script>
<?php
} elseif(isset($_POST['updateSubmit'])){ // if the update subscription form was submitted
	showBTHeader("Subscription Updated", "Subscription Updated");
	showBTLeftNav();
	$subscrId = strip_tags($_POST['subscriptionId']);
	$price = strip_tags($_POST['price']);
	$planId = strip_tags($_POST['planId']);
	$pmtMethodToken = strip_tags($_POST['pmtMethodToken']);
	$maid = strip_tags($_POST['maid']);

	// @TODO see if the functionality for cleaning up add-ons and discounts can be put into a function or object
	
	// $newAddOnsArray = array();
	// $newDiscountsArray = array();
	// foreach($_POST as $key => $value){
	// 	// find if $key starts with 'newAddOn' and ends with a certain number
	// 	if(preg_match("/^newAddOnAmount/", $key)){
	// 		preg_match("/\d/", $key, $matches);
	// 		$suffix = substr($key, strpos($key, $matches[0]));
	// 		$tempArray = array();
	// 		if(empty($_POST["newAddOnInheritedFromId{$suffix}"])){
	// 			echo "The value for the discount ID is required."; 
	// 		} else {
	// 			$newAddOnInheritedFromId = strip_tags($_POST["newAddOnInheritedFromId{$suffix}"]);
	// 			$tempArray["newAddOnInheritedFromId"] = $newAddOnInheritedFromId;
	// 		}
	// 		if(!empty($_POST["newAddOnAmount{$suffix}"])){
	// 			$newAddOnAmount = strip_tags($_POST["newAddOnAmount{$suffix}"]);
	// 			$tempArray["newAddOnAmount"] = $newAddOnAmount;
	// 		}
	// 		if(!empty($_POST["newAddOnNeverExpires{$suffix}"])){
	// 			$newAddOnNeverExpires = strip_tags($_POST["newAddOnNeverExpires{$suffix}"]);
	// 			$tempArray["newAddOnNeverExpires"] = $newAddOnNeverExpires;
	// 		}
	// 		if(!empty($_POST["newAddOnNumberOfBillingCycles{$suffix}"])){
	// 			$newAddOnNumberOfBillingCycles	= strip_tags($_POST["newAddOnNumberOfBillingCycles{$suffix}"]);
	// 			$tempArray["newAddOnNumberOfBillingCycles"] = $newAddOnNumberOfBillingCycles;
	// 		}
	// 		if(!empty($_POST["newAddOnQuantity{$suffix}"])){
	// 			$newAddOnQuantity = strip_tags($_POST["newAddOnQuantity{$suffix}"]);
	// 			$tempArray["newAddOnQuantity"] = $newAddOnQuantity;
	// 		}
	// 		array_push($newAddOnsArray, $tempArray);
	// 	} elseif(preg_match("/^newDiscountAmount/", $key)){
	// 		preg_match("/\d/", $key, $matches);
	// 		$suffix = substr($key, strpos($key, $matches[0]));
	// 		$tempArray = array();
	// 		if(empty($_POST["newDiscountInheritedFromId{$suffix}"])){
	// 			echo "The value for the discount ID is required."; 
	// 		} else {
	// 			$newDiscountInheritedFromId = strip_tags($_POST["newDiscountInheritedFromId{$suffix}"]);
	// 			$tempArray["newDiscountInheritedFromId"] = $newDiscountInheritedFromId;
	// 		}
	// 		if(!empty($_POST["newDiscountAmount{$suffix}"])){
	// 			$newDiscountAmount = strip_tags($_POST["newDiscountAmount{$suffix}"]);
	// 			$tempArray["newDiscountAmount"] = $newDiscountAmount;
	// 		}
	// 		if(!empty($_POST["newDiscountNeverExpires{$suffix}"])){
	// 			$newDiscountNeverExpires = strip_tags($_POST["newDiscountNeverExpires{$suffix}"]);
	// 			$tempArray["newDiscountNeverExpires"] = $newDiscountNeverExpires;
	// 		}
	// 		if(!empty($_POST["newDiscountNumberOfBillingCycles{$suffix}"])){
	// 			$newDiscountNumberOfBillingCycles	= strip_tags($_POST["newDiscountNumberOfBillingCycles{$suffix}"]);
	// 			$tempArray["newDiscountNumberOfBillingCycles"] = $newDiscountNumberOfBillingCycles;
	// 		}
	// 		if(!empty($_POST["newDiscountQuantity{$suffix}"])){
	// 			$newDiscountQuantity = strip_tags($_POST["newDiscountQuantity{$suffix}"]);
	// 			$tempArray["newDiscountQuantity"] = $newDiscountQuantity;
	// 		}
	// 		array_push($newDiscountsArray, $tempArray);
	// 	} // END elseif(preg_match("/^newDiscountAmount/", $key))
	// } // END foreach()
	
	// testing class AddOn_Discount
	require_once(LIB_PATH . DS ."inc". DS ."AddOn_Discount.inc.php");
	$addDisc = new AddOn_Discount();
	echo "AddOns: "; var_dump($addDisc->newAddOnsArray);
	echo "<br><br>";
	echo "Discounts: "; var_dump($addDisc->newDiscountsArray); exit();

	if(empty($newAddOnsArray)){ echo "Empty"; } else { echo "<br>New AddOns array: "; var_dump($newAddOnsArray); echo "<br><br>"; }
	if(empty($newDiscountsArray)){ echo "Empty"; } else { echo "<br>New Discounts array: "; var_dump($newDiscountsArray); }

	// @TODO show updated fields, or show errors 
	// run update method using a subscription ID 
	// $result = Braintree_Subscription::update($subscriptionId, [
		// if(isset($)){

		// }		
		// 'addOns' => [
		// 	'add' => [
		// 		'amount' => '',
		// 		'inheritedFromId' => '',
		// 		'neverExpires' => '',
		// 		'numberOfBillingCycles' => '',
		// 		'quantity' => ''
		// 	],
		// 	'update' => [
		// 		'amount' => '',
		// 		'existingId' => '',
		// 		'neverExpires' => '',
		// 		'numberOfBillingCycles' => '',
		// 		'quantity' => ''
		// 	],
		// 	'remove' => [
		// 		// list of susbscription ID strings - ex.: 's2y551z'
		// 	]
		// ],
		// 'discounts' => [
		// 	'add' => [
		// 		'amount' => '',
		// 		'inheritedFromId' => '',
		// 		'neverExpires' => '',
		// 		'numberOfBillingCycles' => '',
		// 		'quantity' => ''
		// 	],
		// 	'update' => [
		// 		'amount' => '',
		// 		'existingId' => '',
		// 		'neverExpires' => '',
		// 		'numberOfBillingCycles' => '',
		// 		'quantity' => ''
		// 	],
		// 	'remove' => [

		// 	]
		// ],	
		// 'descriptor' => [
		// 	'name' => '',
		// 	'phone' => '',
		// 	'url' => ''
		// ],
		// 'neverExpires' => '', // boolean
		// 'numberOfBillingCycles' => '',
		// 'options' => [
		// 	'prorateCharges' => '', // boolean
		// 	'replaceAllAddonsAndDiscounts' => '', // boolean
		// 	'revertSubscriptionOnProrationFailure' => '' // boolean
		// ],
	// 	'id' => $subcrId,
	// 	'paymentMethodToken' => $pmtMethodToken,
	// 	'price' => $price,
	// 	'planId' => $planId,
	// 	'merchantAccountId' => $maid
	// ]);
	var_dump($_POST);
	echo "<br><br>";

} else {
	showBTHeader("Update a Subscription", "Choose a Subscription to Update");
	showBTLeftNav();

// list available subscriptions
	$collection = Braintree_Subscription::search([
		Braintree_SubscriptionSearch::status()->in(
			[
				Braintree_Subscription::ACTIVE,
				Braintree_Subscription::PENDING
			]
		)
	]);
?>
		<div class="col-md-10">
<?php showForm(); ?>
			<table id="subscriptionTable" class="table table-hover">
				<thead>
					<tr>
						<td>Subscription ID</td>
					</tr>
				</thead>
				<tbody>
<?php
		foreach($collection->_ids as $id){
			echo "<tr><td class='planClick'>$id</td></tr>";
		}
?>
				</tbody>
			</table>
		</div>
	</div>
<?php
} // END else



// show form with fields populated for chosen subscription

// sanitize and filter values submitted. (try https://github.com/Respect/Validation/blob/master/composer.json)
?>
	<script>
		$(".planClick").on('click', function(){
			var theLink = $(this);
			$("#planNameBox").val(theLink.text());
		});
	</script>
<?php
showBTFooter();
?>