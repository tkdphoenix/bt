<?php
/* example from https://developers.braintreepayments.com/guides/marketplace/create/ruby#creating-transactions-without-escrow
$result = Braintree::Transaction.sale(
  :merchant_account_id => "provider_sub_merchant_account",
  :amount => "10.00",
  :payment_method_nonce => nonce_from_the_client,
  :service_fee_amount => "1.00"
)
*/
?>