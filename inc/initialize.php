<?php
define("DS", DIRECTORY_SEPARATOR);
define("URL_ROOT", $_SERVER['SERVER_NAME']); // bt.com
define("SITE_ROOT", $_SERVER['DOCUMENT_ROOT']); // /var/www/bt/public_html
define("LIB_PATH", DS . "var" . DS . "www" . DS . "bt"); // /var/www/bt
define("PROTOCOL", $_SERVER['REQUEST_SCHEME']); // http vs. https
define("DOMAIN_NAME", $_SERVER['HTTP_HOST']); // bt.com
define("URL_PATH", PROTOCOL ."://". DOMAIN_NAME); http://bt.com
?>