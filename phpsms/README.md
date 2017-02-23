PHPSMS
======

PHP SMS mailer based on textbelt https://github.com/typpo/textbelt


###Requires Composer

###Example usage:
```
require 'vendor/autoload.php';

//number to text
$number = '##########';

//message to be sent
$message = 'YO! james what up';

$phpsms = new PHPSMS\PHPSMS($number,$message);

//with a different From
$from = 'myemail@test.com'
$phpsms = new PHPSMS\PHPSMS($number,$message,$from);

//not sending to the us - note totally untested
$region = 'canada';
$phpsms = new PHPSMS\PHPSMS($number,$message,$from,$region);

```
