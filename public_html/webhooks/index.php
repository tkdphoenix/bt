<?php
file_put_contents("webhook.log", "Testing file\r\n", FILE_APPEND);

defined("DS")? null : require_once(realpath(dirname(__FILE__) . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "..") . DIRECTORY_SEPARATOR . "inc" . DIRECTORY_SEPARATOR . "initialize.php");

require_once(LIB_PATH . DS . "btVars.php");
require_once(LIB_PATH . "inc". DS ."common.inc.php");

if(isset($_GET['bt_challenge'])){
	$result = Braintree_WebhookNotification::verify($_GET['bt_challenge']);
	file_put_contents("webhook.log", "Webhook registered - " . $result . "x x x x" ."\r\n", FILE_APPEND);
	
	// send SMS message
	$smsUrl = "http://textbelt.com/text";
	$params = array("number" => 6023123846, "message" => "Your webhook went off!");
	$smsVars = httpPost($smsUrl, $params);
} else if(isset($_POST["bt_signature"]) && isset($_POST["bt_payload"])){
    $webhookNotification = Braintree_WebhookNotification::parse(
        strip_tags_special_chars($_POST["bt_signature"]), strip_tags_special_chars($_POST["bt_payload"])
    );

    $message =
        "[Webhook Received " . $webhookNotification->timestamp->format('Y-m-d H:i:s') . "] "
        . "Kind: " . $webhookNotification->kind . " | "
        . "Subscription: " . $webhookNotification->subscription->id . "\n\r";
	// send SMS message
	$smsUrl = "http://textbelt.com/text";
	$params = array('number' => 6023123846, 'message' => $message);
	$smsVars = httpPost($smsUrl, $params);
    file_put_contents("webhook.log", $message, FILE_APPEND);

} else {
	file_put_contents("webhook.log", "Attempt falied\r\n", FILE_APPEND);
	// send SMS message
	$smsUrl = "http://textbelt.com/text";
	$params = array('number' => 6023123846, 'message' => "Your webhook didn't work, but something happened!");
	$smsVars = httpPost($smsUrl, $params);
	file_put_contents("webhook.log", "Tried to create smsVars after try/catch: ". print_r($smsVars) ."\r\n", FILE_APPEND);

}

?>