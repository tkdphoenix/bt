<?php
// Sandbox configuration
// require_once("braintree-php-2.38.0/lib/Braintree.php");
require_once("braintree-php-3.9.0/lib/Braintree.php");
Braintree_Configuration::environment('sandbox');
// My Creds:
Braintree_Configuration::merchantId('w23gxftvk5dhcygm');
Braintree_Configuration::publicKey('6s8d5ncc2qdpcx6c');
Braintree_Configuration::privateKey('9b74c84bf9266bf0481ed789b7e8e80a');

// Test Creds for merchant:
// Braintree_Configuration::merchantId('2qtv6c9f7fbbrdn9');
// Braintree_Configuration::publicKey('rwh3vfpvhfk79r83');
// Braintree_Configuration::privateKey('3dc6c8038f6a6f428ad209b757f84b13');

