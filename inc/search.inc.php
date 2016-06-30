<section>
<?php
$textAttrs = array(
	'id',
	'transactionId'
);
$rangeAttrs = array(
	'billingCyclesRemaining', // range
	'daysPastDue', // range
	'nextBillingDate', // range
	'price' // range
);
$multiAttrs = array(
	'ids', // multiple
	'inTrialPeriod', // multiple
	'merchantAccountId', // multiple
	'planId', // multiple
	'status' /* multiple
				ACTIVE
				CANCELED
				PAST_DUE
				PENDING
				EXPIRED */

);
?>

	<!-- attempting to add another drop-down for search options -->
	<div id="firstSearch" class="form-group searchLine">
		<div class="btn-group">
			<button type="button" class="btn greenBtn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				Attribute to Search <span class="caret"></span>
			</button>
			<ul class="dropdown-menu">
				<li class="dropdown-header">Text Values</li>
<?php
foreach($textAttrs as $attr){
	echo "<li><a class='ddClick' href='#'>{$attr}</a></li>";
}
?>
				<li role="separator" class="divider"></li>
				<li class="dropdown-header">Range Values</li>
<?php
foreach($rangeAttrs as $attr){
	echo "<li><a class='ddClick' href='#'>{$attr}</a></li>";
}
?>
				<li role="separator" class="divider"></li>
				<li class="dropdown-header">Multiple Values</li>
<?php
foreach($multiAttrs as $attr){
	echo "<li><a class='ddClick' href='#'>{$attr}</a></li>";
}
?>
			</ul>
		</div>


		<div class="btn-group">
			<button type="button" class="btn greenBtn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				Search Condition <span class="caret"></span>
			</button>
			<ul class="dropdown-menu">
				<li><a class="ddClick" href="#">is</a></li>
				<li><a class="ddClick" href="#">is not</a></li>
				<li><a class="ddClick" href="#">starts with</a></li>
				<li><a class="ddClick" href="#">ends with</a></li>
				<li><a class="ddClick" href="#">contains</a></li>
				<li><a class="ddClick" href="#">greater than or equal to</a></li>
				<li><a class="ddClick" href="#">less than or equal to</a></li>
				<li><a class="ddClick" href="#">between</a></li>
				<!-- if you need a separator for different sub-sections on the drop down
				<li role="separator" class="divider"></li>
				<li><a href="#">Separated link</a></li> -->
			</ul>
		</div>
		<input type="text" name="valAttr" placeholder="value of attribute">
		<span class="glyphicon glyphicon-plus-sign greenIcon"></span>
	</div>
<!-- glyphicon glyphicon-plus-sign -->