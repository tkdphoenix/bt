# Braintree Code
Braintree pre-training in Chicago


This code is meant as a test area for Braintree code.

## Technologies Used
This code uses PHP, JavaScript, and Apache

###Dependencies
This code depends on the Braintree SDK found [here](https://developers.braintreepayments.com/start/hello-server/php).

Most pages require the 'initialize.php' file found in the 'inc' directory (explained below). This file sets up common paths to folders. This is set to use the directory separator for the current operating system and should change automatically.

###Directories 
The 'inc' directory contains includes, such as common.inc.php which has common include functions like the header, footer, and navigation for the page.

The 'log' directory is where error logs are housed.

The 'public_html' directory is where public files and directories are housed, such as css, js, images, and php files. **This should be the root of the server**.
