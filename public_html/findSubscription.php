<?php
	(isset($_SESSION['plans'])) ?  : session_start();
	session_regenerate_id();

	// session_start();
	// prevent session hijacking
	session_regenerate_id();

	defined("DS")? null : require_once(realpath(dirname(__FILE__) . DIRECTORY_SEPARATOR . "..") . DIRECTORY_SEPARATOR . "inc" . DIRECTORY_SEPARATOR . "initialize.php");

	require_once(LIB_PATH . DS . "btVars.php");
	require_once(LIB_PATH . DS . "inc" . DS . "common.inc.php");

	function showForm($values=NULL){
?>
		<form id="" action="?" method="post">
			<input id="planNameBox" type="text" name="subscrId" placeholder="Subscription ID" tabindex="10">
			<input class="btn greenBtn" type="submit" name="submit" value="Submit" tabindex="20">
		</form>
<?php		
	} // END showForm()

	if(isset($_POST['submit'])){
		showBTHeader("Subscription Find Results", "Subscription Find Results");
		showBTLeftNav();
		$subscriptionId = strip_tags($_POST['subscrId']);
		$subscription = Braintree_Subscription::find($subscriptionId);
?>
		<div class="col-md-10">
<?php
			var_dump($subscription);
			echo "<br><br>";
			echo "<br>Billing Day of the Month: ". $subscription->billingDayOfMonth;
			echo "<br>";

			// var_dump($subscription->billingPeriodStartDate);
			// echo "<br>Time: ". date_format($subscription->billingPeriodStartDate,"m/d/Y H:i:s T");
			// exit();
			echo "<br>Billing Period Start Date: ". date_format($subscription->billingPeriodStartDate,"m/d/Y H:i:s T");
			echo "<br>Date Updated: ". date_format($subscription->updatedAt,"m/d/Y H:i:s T");
			

			echo "<br>Current Billing Cycle: {$subscription->currentBillingCycle}";
			echo "<br>Days Past Due: "; echo (is_null($subscription->daysPastDue))? "0" : $subscription->daysPastDue;
			// for addOns
			if(!is_null($subscription->addOns)){
				$temp = 1;
				foreach ($subscription->addOns as $addon){
					echo "<br><br><b>Add On {$temp}</b>";
					echo "<br>Amount {$temp}: ". $addon->amount;
					echo "<br>Current Billing Cycle: ". $addon->currentBillingCycle;
					echo "<br>Add On ID: ". $addon->id;
					echo "<br>". $addon->name;
					if($addon->neverExpires){
						echo "<br>Discount Never Expires: true";	
					} else {
						echo "<br>Never Expires: false";
					}
					echo "<br>Number of Billing Cycles: ". ($addon->numberOfBillingCycles)? $addon->numberOfBillingCycles : "Never Ends";
					echo "<br>". $addon->quantity;
				}
			} else {
				echo "<br>Add Ons: None";
			}
			// for discounts
			if(!is_null($subscription->discounts)){
				$temp = 1;
				foreach ($subscription->discounts as $discount){
					echo "<br><br><b>Discount {$temp}</b>";
					echo "<br>Amount {$temp}: ". $discount->amount;
					echo "<br>Current Billing Cycle: ". $discount->currentBillingCycle;
					echo "<br>Discount ID: ". $discount->id;
					echo "<br>Name: ". $discount->name;
					if($discount->neverExpires){
						echo "<br>Discount Never Expires: true";	
					} else {
						echo "<br>Never Expires: false";
					}
					echo "<br>Number of Billing Cycles: ". ($discount->numberOfBillingCycles) ? $discount->numberOfBillingCycles : "Never Ends";
					echo "<br>Quantity: ". $discount->quantity;
					$temp++;
				}
			} else {
				echo "<br>Discounts: None";
			}
			echo "<br>Failure Count: {$subscription->failureCount}";
			echo "<br>First Billing Date: ". date_format($subscription->firstBillingDate,"m/d/Y H:i:s T");
			echo "<br>Subscription ID: {$subscription->id}";
			echo "<br>Never Expires: ". ($subscription->neverExpires)? "true": "false";
			echo "<br>Next Bill Amount: $subscription->nextBillAmount";
			echo "<br>Next Billing Date: ". date_format($subscription->billingPeriodStartDate,"m/d/Y H:i:s T");

			echo "<br>Number of Billing Cycles: ". ($subscription->numberOfBillingCycles)? $subscription->numberOfBillingCycles : "Never Ends";
			echo "<br>Payment Method Token: ". $subscription->paymentMethodToken;
			echo "<br>Subscription Plan ID: {$subscription->planId}";
			echo "<br>Subscription Price: {$subscription->price}";
			echo "<br>Subscription Status: {$subscription->status}"; 
			echo "<br>Trial Period: "; echo ($subscription->trialPeriod)? "Yes" : "No";
			if(isset($subscription->trialPeriod)){
				echo "<br>Trial Period Length: ". $subscription->trialDuration ." ";
				echo ($subscription->trialDuration > 1)? "{$subscription->trialDurationUnit}s" : "{$subscription->trialDurationUnit}";
			}
?>
			<h3>Transaction Information</h3>
			<table class="table table-hover">
				<thead>
					<tr>
						<td>ID</td>
						<td>Status</td>
						<td>Type</td>
						<td>Amount</td>
						<td>Date</td>
						<td>Customer Name</td>
						<td>Customer ID</td>
						<td>Customer Email</td>
						<td>Payment Method Token</td>
					</tr>
				</thead>
				<tbody>
					<tr>
<?php
	foreach($subscription->transactions as $txn){
?>
						<td><?=$txn->id?></td>	
						<td><?=$txn->status?></td>	
						<td><?=$txn->type?></td>	
						<td><?=$txn->amount?></td>	
						<td><?php date_format($txn->createdAt,"m/d/Y H:i:s T"); ?></td>	
						<td><?php echo $txn->customer["firstName"] ." ". $txn->customer["lastName"];?></td>	
						<td><?=$txn->customer["id"]?></td>	
						<td><?=$txn->customer["email"]?></td>	
						<td><?php echo ($txn->creditCard["token"]) ? "{$txn->creditCard["token"]}" : "";?> <img src="<?=$txn->creditCard['imageUrl']?>"></td>
<?php
	}
?>
					</tr>
				</tbody>
			</table>
		</div>
<?php
	} else {
		showBTHeader("Find a Subscription", "Find a Subscription");
		showBTLeftNav();
?>
	<div class="col-md-10">
<?php
	showForm();
	$collection = Braintree_Subscription::search([
		Braintree_SubscriptionSearch::status()->in(
			[
				Braintree_Subscription::ACTIVE,
				Braintree_Subscription::CANCELED,
				Braintree_Subscription::EXPIRED,
				Braintree_Subscription::PAST_DUE,
				Braintree_Subscription::PENDING
			]
		)
	]);
	$arrOfSubscriptionIds = $collection->_ids;
?>
		<h3>List of Subscription IDs</h3>
		<table id="subscriptionTable" class="table table-hover">
			<thead>
				<tr>
					<td>Subscription ID</td>
				</tr>
			</thead>
			<tbody>
<?php
	// store plans as a 2 dimensional array so that you can capture details about 
	// the specific plan to show on the results page.
	$planCount = 0;
	foreach($arrOfSubscriptionIds as $subId){

?>
		<tr class="subscrGroup">
			<td class="planClick"><?=$subId?></td>
		</tr>
<?php
		$planCount++;
	} // END foreach($plans as $plan)


?>
			</tbody>
		</table>
	</div> <!-- END .col-md-10 -->
	<script>
		$(".planClick").on('click', function(){
			var theLink = $(this);
			$("#planNameBox").val(theLink.text());
		});
	</script>
<?php
} // END else
showBTFooter();
?>