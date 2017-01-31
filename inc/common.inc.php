<?php
// log file for errors on Braintree pages
// @todo this is not correct - should be absolute
$pathToBTErrorLog 	= realpath(dirname(__FILE__) .DS. '..') .DS. "logs" .DS. "BraintreeErrors.txt";

function strip_tags_trim($string){
	return trim(strip_tags($string));
}

/**
 * This is the header specific to Braintree separated out for code reuse and ease of maintenance
 *
 * @param [string] $title The page title for the title tag
 * @param [string] $heading The heading at the top of the page
 * @return void
 */
function showBTHeader($title, $heading){
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?=$title?></title>
	<link rel="stylesheet" href="<?php echo "bootstrap-3.3.4-dist" .DS. "css" .DS. "bootstrap.min.css"?>">
	<link rel="stylesheet" href="<?php echo "css" .DS. "btStyles.css"?>">
	<script src="<?php echo "js" .DS. "jquery-2.1.1.min.js"?>"></script>
</head>
<body>
	<section class="container">
		<div class="row">
			<div class="col-md-12">
				<h1 class="text-center"><?=$heading?></h1>
			</div>
		</div>
		<div class="row">
<?php
} // end showBTHeader()

/**
 * This is the left navigation for Braintree pages
 * @return void
 */
function showBTLeftNav(){
?>
			<div class="col-md-2 leftNav">
				<h3>Navigation</h3>
				<ul class="nav nav-pills nav-stacked">
					<li>
						<h4>Payments</h4>
						<a href="index.php">Custom Checkout Payment</a></li>
					<li><a href="dropin.php">Dropin UI</a></li>
					<li><a href="hostedFields.php">Hosted Fields</a></li>
					<li><a href="settlement.php">Settlement</a></li>
					<li><a href="payWithToken.php">Pay with Token</a></li>
					<li><a href="refund.php">Refund a Transaction</a></li>
					<li><a href="void.php">Void a Transaction</a></li>
					<li>
						<h4>Customers</h4>
						<a href="createCustomer.php">Create Customer</a></li>
					<li><a href="findCustomer.php">Find Customer</a></li>
					<li><a href="updateCustomer.php">Update Customer</a></li>
					<li><a href="deleteCustomer.php">Delete Customer</a></li>
					<li>
						<h4>Subscriptions</h4>
						<a href="cancelSubscription.php">Cancel Subscription</a>
						<a href="createSubscription.php">Create Subscription</a>
						<a href="findSubscription.php">Find Subscription</a>
						<a href="retrySubscription.php">Retry Subscription Charge</a>
						<a href="searchSubscription.php">Search Subscription</a>
						<a href="updateSubscription.php">Update Subscription</a>
					</li>
					<li>
						<h4>3D Secure</h4>
						<a href="3DS.php">3D Secure Checkout</a>
					</li>
					<li>
						<h4>Marketplace</h4>
						<a href="createSubMerchantAccount.php">Create Sub-Merchant</a>
						<a>Confirm Sub-Merchant Account</a> <!-- href="confirmSubMerchantAccount.php" -->
						<a href="updateSubMerchantAccount.php">Update Sub-Merchant Account</a>
						<a>Create Sub-Merchant Transaction</a> <!-- href="createSMTransaction.php" -->
					</li>
				</ul>
			</div>
<?php
} // end showBTLeftNav()

/**
 * This is the footer for Braintree pages
 * @return void
 */
function showBTFooter(){
?>
		</div> <!-- END .row -->
	</section> <!-- END .container -->
</body>
</html>
<?php
} // end showBTFooter()

/**
 * Time method to show default time as date and current time in Phoenix, AZ, USA
 * @return [string] the date string as m/d/y H:i:s
 */
function timeNow(){
	date_default_timezone_set('America/Phoenix');
	$date = date('m/d/y H:i:s');
	return $date;
} // end timeNow()

/**
 * send data to a URL using cURL and parameters passed from an array
 * 
 * @param [string] $url The URL to send the cURL request to
 * @param [array] $params The parameters passed to the cURL request
 * @return [array] $output Returned from the API call to provide information to the developer.
 */
function httpPost($url,$params){
	$postData = '';
	// create name value pairs seperated by &
	foreach($params as $k => $v) 
	{ 
	  $postData .= $k . '='.$v.'&';
	}
	// remove the last '&' character from the string
	$postData = rtrim($postData, '&');
    $ch = curl_init();  
 
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch,CURLOPT_HEADER, false);
    // curl_setopt($ch, CURLOPT_POST, count($postData));
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);    
 
    $output=curl_exec($ch);
 	
    curl_close($ch);
    return $output;
 
} // END httpPost()

/**
 * Send push notifications to an IP address or phone number 
 * @param Array $params an array of the values to push to the URL
 * @uses httpPost() to create the cURL call
 * @return array this returns an object with parameters to indicate success or failure
 * @see http://textbelt.com/ Provides object parameters returned from call. There are limitations on number of notifications that can be sent to a phone number or IP address, and phone carriers may not support messages from this API.
 */
function sendPush($params){
	$smsUrl = "http://textbelt.com/text";
	// $params = array('number' => 4027402549, 'message' => 'Please add funds to your student\'s lunch account.');
	$smsVars = httpPost($smsUrl, $params);
	return $smsVars;
}

/**
 * parse an object and save the variable as a new line on a string for troubleshooting
 * @param  [object] $obj    	the object to be parsed
 * @param  string $prefix 		If there is a prefix like "my_" that needs to be looped through
 * @return string $stringRtrn	end result should be a string that can be echoed to the screen or parsed into DB, etc.
 */
function parseObj($obj, $prefix = ''){
	$stringRtrn = '';
	foreach($obj as $key=>$value){
		echo "qqq<br>";
		if($prefix){
			$stringRtrn .= "aaa<br>";
			if(is_array($key)){
				$stringRtrn .= "bbb<br>";
				foreach($key as $k=>$v){
					parseObj($key, $$obj);
				}
			} elseif(is_object($key)){
				$stringRtrn .= "ccc<br>";
				parseObj($key, $$obj);
			} else{
				$stringRtrn .= "asdfjkl;<br>";
				if(is_array($value)){
					$stringRtrn .= "ddd<br>";
					parseObj($value, $key);
				} elseif(is_object($value)){
					$stringRtrn .= "eee<br>";
					parseObj($value, $key);
				} else {
					$stringRtrn .= "fff<br>";
					$stringRtrn .= $prefix ."_". $key ." = ". $value ."<br>";
				}
			}
		} else { // end if($prefix)
		     $stringRtrn .= "zzz<br>";
			if(is_array($key)){
				$stringRtrn .= "ggg<br>";
				parseObj($key, $obj);
			} elseif(is_object($key)){
				$stringRtrn .= "hhh<br>";
				parseObj($key, $obj);
			} else {
				if(is_array($value)){
					$stringRtrn .= "iii<br>";
					parseObj($value, $key);
				} elseif(is_object($value)){
					$stringRtrn .= "jjj<br>";
					parseObj($value, $key);
				} else {
					$stringRtrn .= "kkk<br>";
					$stringRtrn .= $key ." = ". $value ."<br>";
				} // end inner switch 
			} // end outer switch
		} // end else
	} // end foreach($obj as $key=>$value)
	$stringRtrn .= "yyy<br>";
	return $stringRtrn;
} // END parseObj()
