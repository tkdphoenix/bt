<?php
defined("DS")? null : require_once(realpath(dirname(__FILE__) . DIRECTORY_SEPARATOR . "..") . DIRECTORY_SEPARATOR . "inc" . DIRECTORY_SEPARATOR . "initialize.php");

require_once(LIB_PATH . DS . "btVars.php");
require_once(LIB_PATH . DS . "inc" . DS . "common.inc.php");
function showForm(){
?>
	<form id="cancelForm" class="form-horizontal" action="<?php echo htmlspecialchars("?"); ?>" method="post">
		<input type="text" id="subscrId" name="subscrId" placeholder="Subscription ID" tabindex="5">
		<input type="submit" class="btn greenBtn" name="cancelSubmit" value="Cancel Subscription">
	</form>
<?php
} // END showForm()

if(isset($_POST['cancelSubmit'])){
	$subscrId = strip_tags($_POST['subscrId']);
	showBTHeader("Subscription Cancellation", "Subscription Cancellation");
	showBTLeftNav();
	// try{ @TODO work on code to allo BT errors to show, but more neatly than var_dump()
		$result = Braintree_Subscription::cancel($subscrId);
		if($result->success){
			echo "<div class='col-md-10'><p>Subscription $subscrId has been canceled.</p>";
		} else {
			// throw new Exception($error->message, $error->code);
			var_dump($result);
		}
	// } catch(Exception $e){
		
		// echo "<p>Error: ". $e->getCode() ." - ". $e->getMessage() ."\r\nLine: ". $e->getLine() ."File: ". $e->getFile() ."</p>";
	// }
} else {
	showBTHeader("Cancel a Subscription", "Cancel a Subscription");
	showBTLeftNav();
?>
<div class="col-md-10">
<?php
	showForm();

	// run a search for each type of status separately so they can be shown separately.
	$activeCollection = Braintree_Subscription::search([
		Braintree_SubscriptionSearch::status()->in(
			[
				Braintree_Subscription::ACTIVE
			]
		)
	]);
	$pastDueCollection = Braintree_Subscription::search([
		Braintree_SubscriptionSearch::status()->in(
			[
				Braintree_Subscription::PAST_DUE
			]
		)
	]);
	$pendingCollection = Braintree_Subscription::search([
		Braintree_SubscriptionSearch::status()->in(
			[
				Braintree_Subscription::PENDING
			]
		)
	]);
?>
	<h3>List of Active Subscription IDs</h3>
<?php
	if(!isset($activeCollection->_ids[0])){
		echo "<p>There are no active subscriptions.</p>";
	} else {
?>
		<table id="active" class="table table-hover">
			<thead>
				<tr>
					<td>Active Subscription IDs</td>
				</tr>
			</thead>
			<tbody>
<?php
		for($i=0, $ii=count($activeCollection->_ids); $i<$ii; $i++){
?>
				<tr>
					<td class="subscrClick"><?=$activeCollection->_ids[$i]?></td>
				</tr>
<?php
		} // END for loop
	} // END else 
?>
		</tbody>
	</table>

	<h3>List of Past Due Subscription IDs</h3>
<?php
	if(!isset($pastDueCollection->_ids[0])){
		echo "<p>There are no past due subscriptions.</p>";
	} else {
?>
		<table id="pastDue" class="table table-hover">
			<thead>
				<tr>
					<td>Past Due Subscription IDs</td>
				</tr>
			</thead>
			<tbody>
<?php
		for($i=0, $ii=count($pastDueCollection->_ids); $i<$ii; $i++){
?>
				<tr>
					<td class="subscrClick"><?=$pastDueCollection->_ids[$i]?></td>
				</tr>
<?php
		} // END for loop
	} // END else 
?>
		</tbody>
	</table>

	<h3>List of Pending Subscription IDs</h3>
<?php
	if(!isset($pendingCollection->_ids[0])){
		echo "<p>There are no pending subscriptions.</p>";
	} else {
?>
		<table id="pending" class="table table-hover">
			<thead>
				<tr>
					<td>Pending Subscription IDs</td>
				</tr>
			</thead>
			<tbody>
<?php
		for($i=0, $ii=count($pendingCollection->_ids); $i<$ii; $i++){
?>
				<tr>
					<td class="subscrClick"><?=$pendingCollection->_ids[$i]?></td>
				</tr>
<?php
		} // END for loop
	} // END else 

?>
		</tbody>
	</table>


</div> <!-- END .col-md-10 -->
<script>
	$(".subscrClick").on('click', function(){
		var theLink = $(this);
		$("#subscrId").val(theLink.html());
	});
</script>
<?php
} // END else 
showBTFooter();
?>
