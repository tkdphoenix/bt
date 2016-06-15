<?php
defined("DS")? null : require_once(realpath(dirname(__FILE__) . DIRECTORY_SEPARATOR . "..") . DIRECTORY_SEPARATOR . "inc" . DIRECTORY_SEPARATOR . "initialize.php");

require_once(LIB_PATH . DS . "btVars.php");
require_once("../inc/common.inc.php");

function showForm(){
?>
		<div class="row">
			<div class="col-md-12">
				<p>Choose a subscription ID and the subscription details will be added to a form for you to update / change. You can only update Pending, Active, and Past Due subscriptions.</p>
				<form id="chooseSubscriptionForm" class="form-horizontal" action="?" method="post">
					<label>Subscription ID
						<input id="planNameBox" type="text" name="subscriptionId" placeholder="Subscription ID" tabindex="10"></label>
					<input class="btn greenBtn" type="submit" name="subscriptionSubmit" value="Submit">
				</form>
			</div>
		</div>
<?php
} // END showForm()

function showUpdateForm($obj=NULL){
?>
		<div class="row">
			<div class="col-md-12">
				<?php echo (isset($obj->id)) ? "<p>Subscription ID: {$obj->id}</p>" : ""; ?>
				<form id="updateSubscriptionForm" class="form-horizontal" action="?" method="post">
<?php
$digit = 35; // to create different tabindex values
if($obj->status == "Active" || $obj->status == "Pending"){
?>
					<label>Subscription ID
						<input type="text" placeholder="Subscription ID" name="subscriptionId" tabindex="10" value="<?=$obj->id?>"></label>
					<label>Price
						<input type="number" placeholder="Price" name="price" tabindex="10" value="<?=$obj->price?>"></label>
					<label>Plan ID
						<input type="text" placeholder="Plan" name="planID" tabindex="20" value="<?=$obj->planId?>"></label>
					<label>Payment Method
						<input type="text" placeholder="Payment Method" name="pmtMethod" tabindex="30" value="<?=$obj->paymentMethodToken?>"></label>
					<!-- @TODO calculate fields for add-ons and discounts with conditionals -->
					<p>Add Ons</p>
<?php
	if(isset($obj->addOns)){
		foreach($obj->addOns as $addon){
?>
					<label>Add On Amount
						<input type="number" placeholder="Amount" name="addOnAmt" tabindex="<?=$digit?>" value="<?=$addon->amount?>"><?php $digit++; ?></label>
					<label>Add On Current Billing Cycle
						<input type="text" placeholder="Current Billing Cycle" name="currBillCycle" tabindex="<?=$digit?>" value="<?=$addon->currentBillingCycle?>"><?php $digit++; ?></label>
					<label>Add On ID
						<input type="text" placeholder="Add On ID" name="addOnId" tabindex="<?=$digit?>" value="<?=$addon->id?>"><?php $digit++; ?></label>
					<label>Add On Name
						<input type="text" placeholder="Add On Name" name="addOnName" tabindex="<?=$digit?>" value="<?=$addon->name?>"><?php $digit++; ?></label>
<?php
			if($addon->neverExpires == true ){
								echo "<label>Add On Never Expires <input type='text' placeholder='Never Expires' name='addOnNeverExpires' tabindex='{$digit}' value='true'></label>"; $digit++;
			} elseif($addon->neverExpires == false){
								echo "<label>Add On Never Expires <input type='text' placeholder='Never Expires' name='addOnNeverExpires' tabindex='{$digit}' value='false'></label>"; $digit++;
			}
?>
					<label>Add On Number of Billing Cycles
						<input type="number" placeholder="Number of Billing Cycles" name="addOnNumBillCycles" tabindex="<?=$digit?>" value="<?=$addon->numberOfBillingCycles?>"><?php $digit++; ?></label>
					<label>Add On Quantity
						<input type="number" placeholder="Quantity" name="addOnQuantity" tabindex="<?=$digit?>" value="<?=$addon->quantity?>"><?php $digit++; ?></label>
<?php
		} // END foreach($obj->addOns as $addon)
	} else {
		echo "<p>There are no Add Ons for this subscription</p>";
	}
?>

					<p>Discounts</p>
<?php
	if(isset($obj->discounts)){
		foreach($obj->discounts as $discount){
?>
					<label>Discount Amount
						<input type="number" placeholder="Amount" name="discountAmt" tabindex="<?=$digit?>" value="<?=$discount->amount?>"><?php $digit++; ?></label>
					<label>Discount Current Billing Cycle
						<input type="text" placeholder="Current Billing Cycle" name="currBillCycle" tabindex="<?=$digit?>" value="<?=$discount->currentBillingCycle?>"><?php $digit++; ?></label>
					<label>Discunt ID
						<input type="text" placeholder="Discount ID" name="discountId" tabindex="<?=$digit?>" value="<?=$discount->id?>"><?php $digit++; ?></label>
					<label>Discount Name
						<input type="text" placeholder="Discount Name" name="discountName" tabindex="<?=$digit?>" value="<?=$discount->name?>"><?php $digit++; ?></label>
<?php
			if($discount->neverExpires == true ){
								echo "<label>Discount Never Expires <input type='text' placeholder='Never Expires' name='discountNeverExpires' tabindex='{$digit}' value='true'></label>"; $digit++;
			} elseif($discount->neverExpires == false){
								echo "<label>Discount Never Expires <input type='text' placeholder='Never Expires' name='discountNeverExpires' tabindex='{$digit}' value='false'></label>"; $digit++;
			}
?>
					<label>Discount Number of Billing Cycles
						<input type="number" placeholder="Number of Billing Cycles" name="discountNumBillCycles" tabindex="<?=$digit?>" value="<?=$discount->numberOfBillingCycles?>"><?php $digit++; ?></label>
					<label>Discount Quantity
						<input type="number" placeholder="Quantity" name="discountQuantity" tabindex="<?=$digit?>" value="<?=$discount->quantity?>"><?php $digit++; ?></label>
<?php
		}
	} else {
		echo "<p>There are no Discounts for this subscription</p>";
	}
?>
					<!-- descriptor is multi-field object - name, phone, url -->
					<p>Descriptor Fields</p>
<?php
	foreach($obj->descriptor as $descrip){
?>
					<label>Descriptor Name
						<input type="text" placeholder="Descriptor Name" name="descripName" tabindex="<?=$digit?>" value="<?=$descrip['name']?>"><?php $digit++; ?></label>
					<label>Descriptor Phone
						<input type="tel" placeholder="Descriptor Phone" name="descripPhone" tabindex="<?=$digit?>" value="<?=$descrip['phone']?>"><?php $digit++; ?></label>
					<label>Descriptor URL
						<input type="url" placeholder="Descriptor URL" name="descripUrl" tabindex="<?=$digit?>" value="<?=$descrip['url']?>"><?php $digit++; ?></label>
<?php
	}

} elseif($obj->status == "Past Due") {
?>
					<label>Subscription ID
						<input type="text" placeholder="Subscription ID" name="subscriptionId" tabindex="10" value="<?=$obj->id?>"></label>
					<label>Payment Method
						<input type="text" placeholder="Payment Method" name="pmtMethod" tabindex="20" value="<?=$obj->id?>"></label>
					<label>Merchant Account
						<input type="text" placeholder="Merchant Account" name="maid" tabindex="30" value="<?=$obj->id?>"></label>
<?php
	foreach($obj->descriptor as $descrip){
?>
					<label>Descriptor Name
						<input type="text" placeholder="Descriptor Name" name="descripName" tabindex="<?=$digit?>" value="<?=$descrip['name']?>"><?php $digit++; ?></label>
					<label>Descriptor Phone
						<input type="tel" placeholder="Descriptor Phone" name="descripPhone" tabindex="<?=$digit?>" value="<?=$descrip['phone']?>"><?php $digit++; ?></label>
					<label>Descriptor URL
						<input type="url" placeholder="Descriptor URL" name="descripUrl" tabindex="<?=$digit?>" value="<?=$descrip['url']?>"><?php $digit++; ?></label>
<?php
	}
}
?>
					<input class="btn greenBtn" type="submit" name="updateSubmit" value="Submit" tabindex="150">
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
<?php
} elseif(isset($_POST['updateSubmit'])){ // if the update subscription form was submitted
	showBTHeader("Subscription Updated", "Subscription Updated");
	showBTLeftNav();

	// @TODO show updated fields, or show errors 
	// run update method using a subscription ID 
	// $result = Braintree_Subscription::update($subscriptionId, [
	//     'id' => 'new_id',
	//     'paymentMethodToken' => 'new_payment_method_token',
	//     'price' => '12.34',
	//     'planId' => 'new_plan',
	//     'merchantAccountId' => 'another_merchant_account'
	// ]);
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