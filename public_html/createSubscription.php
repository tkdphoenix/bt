<?php
// @TODO add payment token table below the input boxes and tie those to the payment token field so that you can click the payment token and it populates into the input field after clearing out text in that box.

defined("DS")? null : require_once(realpath(dirname(__FILE__) . DIRECTORY_SEPARATOR . "..") . DIRECTORY_SEPARATOR . "inc" . DIRECTORY_SEPARATOR . "initialize.php");

require_once(LIB_PATH . DS . "btVars.php");
require_once(LIB_PATH . DS . "inc" . DS . "common.inc.php");

// function to show the form to be filled out
function showForm($errorsArr=[]){
?>
	<div class="col-md-10">
		<div class="row">
			<div class="col-md-12">
				<form id="subscriptionForm" class="form-horizontal" action="<?php echo htmlspecialchars("?"); ?>" method="post">
					<div class="form-group">
						<label for="token" class="sr-only">Payment Token</label>
						<input type="text" class="planBoxes" name="paymentMethodToken" tabindex="10" aria-label="Payment Token" placeholder="Payment Token" required>
						<label for="token" class="sr-only">Subscription Plan</label>
						<input type="text" id="planId" class="planBoxes" name="planId" tabindex="20" aria-label="Subscription Plan" placeholder="Subscription Plan" required>
						<input class="btn greenBtn" type="submit" name="subscriptionSubmit" aria-label="Create Subscription Button" value="Create Subscription">
					</div>
				</form>
			</div>
		</div>
<?php
	// didn't end .col-md-10 since it is the container for the right side of the page.
	// @TODO - be sure to close this tag at the end of adding other stuff to the page where this is shown
} // END showForm()


if(isset($_POST['subscriptionSubmit'])){
	$token = strip_tags($_POST['paymentMethodToken']);
	$planId = strip_tags($_POST['planId']);

	// @TODO perform form validation here

	try{
		// call to create subscription
		$result = Braintree_Subscription::create([
			'paymentMethodToken' 		=> $token,
			'planId' 					=> $planId,
			// 'trialPeriod' 				=> false,
			// 'addOns'					=> [
			// 	'update'				=> [
			// 		[
			// 			'existingId' 			=> 'tax',
			// 			'amount'				=> '2.00'
			// 		]
			// 	]
			// ],
			// 'discounts'					=> [
			// 	'add'					=> [
			// 		[
			// 			'inheritedFromId'	=> 'disc_2_off',
			// 			'amount'			=> '5.00'
			// 		]
			// 	]
			// ]
		]);
		if(!$result->success){
			foreach($result->errors->deepAll() as $error){
				file_put_contents($pathToBTErrorLog, timeNow() . ' MST - ' . $error->code .": ". $error->message ."\r\n", FILE_APPEND);
				throw new Exception($error->message, $error->code);
			}
		} // END if(!$result->success)
	} catch(Exception $e){
		?>
		<div class="container">
		<?php
		echo "Error: ". $e->getCode() ." - ". $e->getMessage() ."<br>";
		// may want to display form here
		?>
			
		</div>
		<?php
	} // END try / catch for !$result->success

	if(isset($result) && $result->success){
		showBTHeader("Successful Subscription", "Successful Subscription");
		showBTLeftNav();
		// put details on the page to show completion
	?>
	<div class="col-md-10">
		<section class="container">
			<h4>Subscription creation successful</h4>
			<p>Your subscription details are as follows:</p>
			<p>Status: <?=$result->subscription->status?><br>
			   Billing Day of the Month: <?=$result->subscription->billingDayOfMonth?><br>
			   Plan ID: <?=$result->subscription->planId?><br>
			   Price: <?=$result->subscription->price?><br>
			   <strong>Discounts:</strong><br>
<?php
		foreach($result->subscription->discounts as $d){
			// print_r($d);
			echo "Amount: ". $d->amount ."<br>";
			echo "ID: ". $d->id ."<br>";
			echo "Name: ". $d->name ."<br>";
			echo "---------------------<br>";
			echo "<br>";
		}
		echo "<a class='btn greenBtn' href='createSubscription.php'>Create a new subscription</a>";
?>
			</p>
		</section>
	</div>
	<?php
	} else {
		showBTHeader("Subscription Error", "Error attempting to create subscription");
		showBTLeftNav();
	?>
		<div class="col-md-10">
			
		</div>
	<?php
	}

} else { // Initial page display
	// start page display
	showBTHeader("Create Subscription", "Subscribe to a Plan");
	showBTLeftNav();
	showForm();
?>
	<div class="row">
		<h2 class="text-center">Payment Tokens</h2>	
		<p>Unfortunately, there isn't an API method to get payment tokens and list them in a table like the subscription plans below. You will need to <a class="greenLink" href="https://www.braintreepayments.com/" target="_blank">log in to Braintree</a> to see your available payment tokens.</p>
	</div>

	<div class="row">
		<table class="table table-hover planTable">
			<caption class="text-center">Subscription Plans</caption>
			<thead>
				<tr>
					<td>Name</td>
					<td>ID</td>
					<td>Price</td>
					<td>Trial Period</td>
					<td>Add On Name</td>
					<td>Add On ID</td>
					<td>Add On Expiration</td>
					<td>Discount Name</td>
					<td>Discount ID</td>
					<td>Discount Expiration</td>
				</tr>
			</thead>
			<tbody>
<?php
	$plans = Braintree_Plan::all();
	// var_dump($spec->addOns[0]->name); exit() 
	foreach($plans as $plan){
		echo "<tr><td><span class='plan'>$plan->name</span></td>";
		echo "<td>$plan->id</td>";
		echo "<td>$plan->price $plan->currencyIsoCode</td>";
		if($plan->trialPeriod){
			echo "<td>$plan->trialDuration $plan->trialDurationUnit</td>";
		} else {
			echo "<td>None</td>";
		}
		if(empty($plan->addOns)){
			echo "<td>n/a</td><td>n/a</td><td>n/a</td>";
		} else {
			// loop through all the add ons for this plan
			echo "<td>"; 
			foreach($plan->addOns as $addOn){
				echo $addOn->name ."\n\r";
			}
			echo "</td>";

			echo "<td>"; 
			foreach($plan->addOns as $addOn){
				echo $addOn->id ."\n\r";
			}
			echo "</td>";

			echo "<td>";
			foreach($plan->addOns as $addOn){
				if($addOn->neverExpires){
					echo "never\n\r";
				} else {
					echo $addOn->numberOfBillingCycles ."\n\r";
				}
			}
			echo "</td>";

		} // END $plan->addOns else
		if(empty($plan->discounts)){
			echo "<td>n/a</td><td>n/a</td><td>n/a</td></tr>";
		} else {
			echo "<td>";
			foreach($plan->discounts as $discount){
				echo $discount->name;
			}
			echo "</td>";

			echo "<td>";

			foreach($plan->discounts as $discount){
				echo $discount->id;
			}
			echo "</td>";

			echo "<td>";
			foreach($plan->discounts as $discount){
				if($discount->neverExpires){
					echo "never\n\r";
				} else {
					echo ($discount->numberOfBillingCycles == 1) ? $discount->numberOfBillingCycles ." cycle\n\r" : $discount->numberOfBillingCycles ." cycles\n\r";

				}
			}
			echo "</td></tr>";
		} // end $plan->discounts else
	}
?>
			</tbody>
		</table>
	</div> <!-- END plan table .row -->
<?php
	$customers = Braintree_Customer::all();
	// echo "<br>All customers: <br>";
	// var_dump($customers); exit()
?>
</section>
<script src="../js/btScript.js"></script>
<?php
	showBTFooter();
} // END else

?>