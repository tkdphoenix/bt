<?php
	defined("DS")? null : require_once(realpath(dirname(__FILE__) . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "..") . DIRECTORY_SEPARATOR . "inc" . DIRECTORY_SEPARATOR . "initialize.php");

	// require_once(LIB_PATH . "vendor". DS ."theseer". DS ."autoload");
	require_once(LIB_PATH . "phpsms". DS ."index.php");

	//number to text
	$number = '6023123846';

	//message to be sent
	$message = 'Your Webhook for blah: ';

	$phpsms = new PHPSMS\PHPSMS($number,$message);

	//with a different From
	// $from = 'joelsppacct@gmail.com';
	$phpsms = new PHPSMS\PHPSMS($number,$message,$from);

	//not sending to the us - note totally untested
	$region = 'us';
	$phpsms = new PHPSMS\PHPSMS($number,$message,$from,$region);