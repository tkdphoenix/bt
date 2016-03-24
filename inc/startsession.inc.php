<?php
  session_start();

  // If the CLASSIC session vars aren't set, try to set them with a cookie
  if (!isset($_SESSION['user'])) {
    if (isset($_COOKIE['user'])) {
      $_SESSION['user'] = $_COOKIE['user'];
      $_SESSION['pwd'] = $_COOKIE['pwd'];
      $_SESSION['signature'] = $_COOKIE['signature'];
    }
  }

  // if the REST session vars aren't set, try to set them with a cookie
  if(!isset($_SESSION['clientID'])){
  	if(isset($_COOKIE['clientID'])){
	  	$_SESSION['clientID'] = $_COOKIE['clientID'];
	  	$_SESSION['secret'] = $_COOKIE['secret'];
    }
  }
  // if the Payflow session vars aren't set, Try to set them with a cookie
  if(!isset($_SESSION['vendor'])){
  	if(isset($_COOKIE['vendor'])){
	  	$_SESSION['pfUser'] = $_COOKIE['pfUser'];
	  	$_SESSION['vendor'] = $_COOKIE['vendor'];
	  	$_SESSION['partner`'] = $_COOKIE['partner'];
	  	$_SESSION['pfPwd'] = $_COOKIE['pfPwd'];
    }
  }

  // good help for starting with PF: https://developer.paypal.com/docs/classic/payflow/gs_payflow/
?>
