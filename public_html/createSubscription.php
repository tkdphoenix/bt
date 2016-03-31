<?php
// @TODO add payment token table below the input boxes and tie those to the payment token field so that you can click the payment token and it populates into the input field after clearing out text in that box.

defined("DS")? null : require_once(realpath(dirname(__FILE__) . DIRECTORY_SEPARATOR . "..") . DIRECTORY_SEPARATOR . "inc" . DIRECTORY_SEPARATOR . "initialize.php");

require_once(LIB_PATH . DS . "btVars.php");
require_once("../inc/common.inc.php");

// function to show the form to be filled out
function showForm($errorsArr=[]){
?>
<form id="subscriptionForm" class="form-horizontal" action="?" method="post">
	<div class="form-group">
		<label for="token">Payment Token
			<input type="text" name="paymentMethodToken" tabindex="10" placeholder="Payment Token" required>
		</label>
		<label for="token">Subscription Plan
			<input type="text" name="planId" tabindex="20" placeholder="Subscription Plan" required>
		</label>
		<input class="btn greenBtn" type="submit" name="subscriptionSubmit" value="Create Subscription">
	</div>
</form>
<?php
} // END showForm()


if(isset($_POST['subscriptionSubmit'])){
	$token = $_POST['paymentMethodToken'];
	$planId = $_POST['planId'];

	// @TODO perform form validation here

	try{
		// call to create subscription
		$result = Braintree_Subscription::create([
			'paymentMethodToken' 		=> $token,
			'planId' 					=> $planId,
			'trialPeriod' 				=> false,
			'addOns'					=> [
				'remove'				=> ['extra_member']
			],
			'discounts'					=> [
				'add'					=> [
					[
						'inheritedFromId'	=> 'disc_2_off',
						'amount'			=> '5.00'
					]
				]
		  ]
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
	}

	if(isset($result) && $result->success){
		showBTHeader("Successful Subscription", "Successful Subscription");
		// put details on the page to show completion
	?>
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
		echo "<br>";
		echo "<a class='btn greenBtn' href='createSubscription.php'>Create a new subscription</a>";
	}
	?>
		</p>
	</section>
	<?php
	}

} else {
	// start page display
	showBTHeader("Create Subscription", "Subscribe to a Plan");
	showBTLeftNav();
?>
	<div class="col-md-7">
		<div class="row">
			<div class="col-md-12">
<?php
	showForm();

?>
</section>
<?php
	showBTFooter();
} // END else

?>