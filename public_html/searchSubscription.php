<?php
	(isset($_SESSION['plans'])) ?  : session_start();
	session_regenerate_id();

// session_start();
// prevent session hijacking
session_regenerate_id();

defined("DS")? null : require_once(realpath(dirname(__FILE__) . DIRECTORY_SEPARATOR . "..") . DIRECTORY_SEPARATOR . "inc" . DIRECTORY_SEPARATOR . "initialize.php");

require_once(LIB_PATH . DS . "btVars.php");
require_once(LIB_PATH . DS . "inc" . DS . "common.inc.php");

function showForm(){
?>
	<form id="findSubscriptionForm" class="form-horizontal" action="?" method="post">
		<input type="text" id="planId" name="planId" placeholder="Plan ID" tabindex="5">
		<input type="hidden" id="planVal" name="planVal">
		<input type="submit" class="btn greenBtn" name="submit" value="Search" tabindex="10">
	</form>
<?php
} // END showForm()

if(isset($_POST['submit'])){
	$planId = strip_tags_special_chars($_POST['planId']);
	$collection = Braintree_Subscription::search([
	  Braintree_SubscriptionSearch::planId()->is($planId)
	]);
	$planIndex = strip_tags_special_chars($_POST['planVal']);
	(isset($_SESSION['plans']) && isset($planIndex)) ? $selectedPlan = $_SESSION['plans'][$planIndex] : '';
	// $selectedPlan = $_SESSION['plans'][$planIndex];
	// Test if a plan has any subscriptions
	if(count($collection->_ids) < 1){ // There are no subscriptions to the given plan
		showBTHeader("No Subscriptions Found", "No Subscriptions");
		showBTLeftNav();
?>
		<div class="col-md-10">There is no one signed up for this plan.</div>
<!-- 		<div class="col-md-5">
			<p>Plan Name: <?=$selectedPlan[0]?></p>
			<p>Price: <?=$selectedPlan[1] ." ". $selectedPlan[2]?></p>
			<p>Trial Period: <?php if($selectedPlan[3]){ echo $selectedPlan[4] ." ". $selectedPlan[5]; if ($selectedPlan[4] != 1){ echo "s"; }} else { echo "None"; }?></p>
			<p>Billing Cycle: <?="Every ". $selectedPlan[6] ." Month(s)"?></p>
		</div> -->
<?php
	} else { // There ARE subscriptions to the given plan
		$active		= 0;
		$canceled	= 0;
		$pastDue	= 0;
		$pending	= 0;
		$expired	= 0;
		foreach($collection as $subscription) {
			// calculate how many of each subscription status there are
			switch($subscription->status){
				case "Active":
					$active++;
					break;
				case "Canceled":
					$canceled++;
					break;
				case "Past Due":
					$pastDue++;
					break;
				case "Pending":
					$pending++;
					break;
				case "Expired":
					$expired++;
					break;
				default:
			} // END switch()
		} // END foreach	
		showBTHeader("Subscriptions Found", "Subscription Details");
		showBTLeftNav();
?>
		<div class="col-md-5">
			<p>Subscriptions on this plan:</p>
			<p>Active <?=$active?></p>
			<p>Canceled <?=$canceled?></p>
			<p>Past Due <?=$pastDue?></p>
			<p>Pending <?=$pending?></p>
			<p>Expired <?=$expired?></p>
		</div> <!-- END .col-md-5 -->
		<div class="col-md-5">
			<p>Plan Name: <?=$selectedPlan[0]?></p>
			<p>Price: <?=$selectedPlan[1] ." ". $selectedPlan[2]?></p>
			<p>Trial Period: <?php if($selectedPlan[3]){ echo $selectedPlan[4] ." ". $selectedPlan[5]; if ($selectedPlan[4] != 1){ echo "s"; }} else { echo "None"; }?></p>
			<p>Billing Cycle: <?="Every ". $selectedPlan[6] ." Month(s)"?></p>
		</div>
<?php
	} // end ELSE 
} else { // END if(isset($_POST['submit']))
	showBTHeader("Search Subscription Plans", "Search Subscription Plans");
	showBTLeftNav();
?>
	<div class="col-md-10">
<?php
	showForm();
	$plans = Braintree_Plan::all();
?>
<h3>List of Subscription Plans</h3>
<table id="planTable" class="table table-hover">
	<thead>
		<tr>
			<td>Plan ID</td>
			<td>Plan Name</td>
			<td>Price</td>
			<td>Trial Period</td>
			<td>Billing Cycle</td>
		</tr>
	</thead>
	<tbody>
<?php
// store plans as a 2 dimensional array so that you can capture details about 
// the specific plan to show on the results page.
$planCount = 0;
foreach($plans as $plan){
	$planArray[$planCount] = array($plan->name, $plan->price, $plan->currencyIsoCode, $plan->trialPeriod, $plan->trialDuration, $plan->trialDurationUnit, $plan->billingFrequency);

?>
		<tr id="plan<?=$planCount?>" class="planGroup">
			<td id="planId" class="planClick"><?=$plan->id?></td>
			<td id="planName"><?=$plan->name?></td>
			<td id="planPrice"><?=$plan->price ." ". $plan->currencyIsoCode?></td>
			<td id="planTrial"><?php if($plan->trialPeriod){ echo $plan->trialDuration ." ". $plan->trialDurationUnit; if ($plan->trialDuration != 1){ echo "s"; }} else { echo "None"; } ?></td>
			<td id="planBillFreq"><?php echo "Every $plan->billingFrequency month(s)"; ?></td>
		</tr>
<?php
	$planCount++;
} // END foreach($plans as $plan)
// set the session variable to hold the plans so that we can later display the specific one for the chosen plan on the response page
$_SESSION['plans'] = $planArray;
?>
		</tbody>
	</table>
</div> <!-- END .col-md-10 -->
<script>
	$(".planClick").on('click', function(){
		var theLink = $(this);
		$("#planId").val(theLink.html());
		var selectedPlan = theLink.parent(".planGroup").attr("id").substr(4);
		$("#planVal").val(selectedPlan);
	});
</script>
<?php
} // END else 
showBTFooter();
?>