<?php
defined("DS")? null : require_once(realpath(dirname(__FILE__) . DIRECTORY_SEPARATOR . "..") . DIRECTORY_SEPARATOR . "inc" . DIRECTORY_SEPARATOR . "initialize.php");

require_once(LIB_PATH . DS . "btVars.php");
require_once("../inc/common.inc.php");

// list all subscriptions that have failed and choose one to retry

if(isset($_POST['submit'])){
	$subIds = strip_tags($_POST['subId']);
} else {
	showBTHeader("Retry Subscription", "List of Failed Subscriptions");
	showBTLeftNav();	// retry the subscription
	$collection = Braintree_Subscription::search([
		Braintree_SubscriptionSearch::status()->is(
				Braintree_Subscription::PAST_DUE
		)
	]);
?>
	<div class="col-md-10">
		
<?php
	echo "The list of past due subscriptions: ";
	var_dump($collection);
}
?>

	</div>
<?php
showBTFooter();
?>