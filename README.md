php-CardStream-Library
======================

a php library made to use cardstream.com's api

``` 
<?php
	require 'cardstream.class.php';
  $cardstream = new CardStream('Circle4Take40Idea');

	  $fields = array(
	  	'action' => 'SALE',
  		'type' => 1,
  		"merchantID" => "100001",
  		"amount" => "1050",
  		"countryCode" => "826",
  		"currencyCode" => "826",
  		"transactionUnique" => "AZ2045-PY",
  		"orderRef" => "Groceries",
  		"customerName" => "Mr PHP Test",
  		"cardNumber" => '4929421234600821',
  		"cardExpiryMonth" => 12,
  		"cardExpiryYear" => date('y')+1,
  		"cardCVV" => 356,
  		"customerAddress" => "Flat 6\nPrimrose Rise\n347 Lavender Road\nNorthampton",
  		"customerPostCode" => 'NN17 8YG',
  		"customerEmail" => 'support@cardstream.com',
  		"customerPhone" => '0845 00 99 575',
  	);

  $res = $cardstream->makeApiCall($fields);

  var_dump($res);

```
