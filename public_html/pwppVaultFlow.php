<?php
  defined("DS")? null : require_once(realpath(dirname(__FILE__) . DIRECTORY_SEPARATOR . "..") . DIRECTORY_SEPARATOR . "inc" . DIRECTORY_SEPARATOR . "initialize.php");
  require_once(LIB_PATH . DS . "inc" . DS . "common.inc.php");
  require_once(LIB_PATH . DS . "btVars.php");

  $clientToken = Braintree_ClientToken::generate();
  if(isset($_POST['payment_method_nonce'])){
    $nonce = strip_tags($_POST['payment_method_nonce']);
    $result = Braintree_Transaction::sale([
      "amount" => 10.00,
      "paymentMethodNonce" => $nonce,
    ]);
if ($result->success) {
  print_r("Success ID: " . $result->transaction->id);
} else {
  print_r("Error Message: " . $result->message);
}
  } else {
    showBTHeader("Pay with PayPal Vault Flow", "Pay with PayPal Vault Flow");
    showBTLeftNav();
?>
    <form id="" action="?" method="post">
      <div id="paypal-container"></div>
      <input id="submit" type="submit" name="submit" aria-label="Submit button" value="Submit">
    </form>
    <script src="https://js.braintreegateway.com/js/braintree-2.24.1.min.js"></script>
    <script type="text/javascript">
    // @TODO collect device data
    braintree.setup("<?=$clientToken?>", "custom", {
      paypal: {
        container: "paypal-container",
        singleUse: false,
        billingAgreementDescription: 'Your agreement description',
        locale: 'en_us',
        enableShippingAddress: true,
        shippingAddressOverride: {
          recipientName: 'Scruff McGruff',
          streetAddress: '1234 Main St.',
          extendedAddress: 'Unit 1',
          locality: 'Chicago',
          countryCodeAlpha2: 'US',
          postalCode: '60652',
          region: 'IL',
          phone: '123.456.7890',
          editable: false
        }
      },
      dataCollector: {
        paypal: true
      },
      onPaymentMethodReceived: function (obj) {
        // doSomethingWithTheNonce(obj.nonce);
        console.log(obj);
        var nonceVal = "<input type='hidden' name='payment_method_nonce' value='"+ obj.nonce +"'>";
        $("#merchant-form").on('submit', function(e){
          e.preventDefault();
        });
        $("#submit").before(nonceVal);
      }
    });
    </script>
<?php
}
?>
  </body>
</html>