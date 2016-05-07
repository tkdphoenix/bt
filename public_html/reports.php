<?php

	defined("DS")? null : require_once(realpath(dirname(__FILE__) . DIRECTORY_SEPARATOR . "..") . DIRECTORY_SEPARATOR . "inc" . DIRECTORY_SEPARATOR . "initialize.php");

	require_once(LIB_PATH . DS . "inc" . DS . "common.inc.php");
	require_once(LIB_PATH . DS . "btVars.php");

	date_default_timezone_set('America/Phoenix');

	$output = fopen('transaction_report.csv', 'w');

	fputcsv($output, ['id', 'type', 'amount', 'status', 'created_at', 'service_fee_amount', 'merchant_account_id']);

	$now = new DateTime();
	$yesterday = $now->modify('-1 day');

	$transactions = Braintree_Transaction::search([
	  Braintree_TransactionSearch::settledAt()->greaterThanOrEqualTo($yesterday)
	]);

	foreach($transactions as $transaction) {
	    $id = $transaction->id;
	    $type = $transaction->type;
	    $amount = $transaction->amount;
	    $status = $transaction->status;
	    $createdAt = $transaction->createdAt->format('d/m/Y H:i:s');
	    $serviceFeeAmount = $transaction->serviceFeeAmount;
	    $merchantAccountId = $transaction->merchantAccountId;

	    $csvrow = [$id, $type, $amount, $status, $createdAt, $serviceFeeAmount, $merchantAccountId];
	    fputcsv($output, $csvrow);
	}