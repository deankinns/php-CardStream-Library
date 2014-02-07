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

Response
========

```
array (size=49)
  'merchantID' => string '100001' (length=6)
  'threeDSEnabled' => string 'N' (length=1)
  'threeDSCheckPref' => string 'authenticated' (length=13)
  'avscv2CheckEnabled' => string 'N' (length=1)
  'cv2CheckPref' => string 'matched' (length=7)
  'addressCheckPref' => string 'matched' (length=7)
  'postcodeCheckPref' => string 'matched' (length=7)
  'customerID' => string '5' (length=1)
  'eReceiptsEnabled' => string 'N' (length=1)
  'eReceiptsStoreID' => string '1' (length=1)
  'action' => string 'SALE' (length=4)
  'type' => string '1' (length=1)
  'amount' => string '1050' (length=4)
  'countryCode' => string '826' (length=3)
  'currencyCode' => string '826' (length=3)
  'transactionUnique' => string 'AZ2045-PY' (length=9)
  'orderRef' => string 'Groceries' (length=9)
  'customerName' => string 'Mr PHP Test' (length=11)
  'customerAddress' => string 'Flat 6
Primrose Rise
347 Lavender Road
Northampton' (length=50)
  'customerPostCode' => string 'NN17 8YG' (length=8)
  'customerEmail' => string 'support@cardstream.com' (length=22)
  'customerPhone' => string '0845 00 99 575' (length=14)
  'customerPostcode' => string 'NN17 8YG' (length=8)
  'merchantAlias' => string '100001' (length=6)
  'responseCode' => string '0' (length=1)
  'responseMessage' => string 'AUTHCODE:6184' (length=13)
  'state' => string 'accepted' (length=8)
  'remoteAddress' => string '82.153.91.208' (length=13)
  'xref' => string '14020711KP29RJ21BZ50NVD' (length=23)
  'cardExpiryDate' => string '1215' (length=4)
  'authorisationCode' => string '6184' (length=4)
  'transactionID' => string '6310462' (length=7)
  'timestamp' => string '2014-02-07 11:29:22' (length=19)
  'amountReceived' => string '1050' (length=4)
  'avscv2ResponseCode' => string '222100' (length=6)
  'avscv2ResponseMessage' => string 'ALL MATCH' (length=9)
  'avscv2AuthEntity' => string 'merchant host' (length=13)
  'cv2Check' => string 'matched' (length=7)
  'addressCheck' => string 'matched' (length=7)
  'postcodeCheck' => string 'matched' (length=7)
  'cardNumberMask' => string '************0821' (length=16)
  'cardTypeCode' => string 'VC' (length=2)
  'cardType' => string 'Visa Credit' (length=11)
  'currencyExponent' => string '2' (length=1)
  'settledTimestamp' => string '2014-02-07 11:29:21' (length=19)
  'responseStatus' => string '0' (length=1)
  'merchantName' => string 'CARDSTREAM TEST' (length=15)
  'merchantID2' => string '100001' (length=6)
  'signature' => string '9e953da7e385135686920ca775e9e49dbb1ec6097c1b04dad3a4208a450f57f4f86e8c78b498ed5ff339dd5cfb76ea7b4cd68e04276c0bb0c386177fcc0292e8' (length=128)
  
```

Using the Xref returned in the above response for future transactions

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
		"orderRef" => "Groceries new transaction",
		"xref" => '14020711KP29RJ21BZ50NVD'

	);
	
  $res = $cardstream->makeApiCall($fields);

  var_dump($res);

```

Response
========

```
array (size=48)
  'merchantID' => string '100001' (length=6)
  'threeDSEnabled' => string 'N' (length=1)
  'threeDSCheckPref' => string 'authenticated' (length=13)
  'avscv2CheckEnabled' => string 'N' (length=1)
  'addressCheckPref' => string 'matched' (length=7)
  'postcodeCheckPref' => string 'matched' (length=7)
  'customerID' => string '5' (length=1)
  'eReceiptsEnabled' => string 'N' (length=1)
  'eReceiptsStoreID' => string '1' (length=1)
  'action' => string 'SALE' (length=4)
  'type' => string '1' (length=1)
  'amount' => string '1050' (length=4)
  'countryCode' => string '826' (length=3)
  'currencyCode' => string '826' (length=3)
  'transactionUnique' => string 'AZ2045-PY' (length=9)
  'orderRef' => string 'Groceries' (length=9)
  'merchantAlias' => string '100001' (length=6)
  'responseCode' => string '0' (length=1)
  'responseMessage' => string 'AUTHCODE:271372' (length=15)
  'state' => string 'accepted' (length=8)
  'remoteAddress' => string '82.153.91.208' (length=13)
  'cardNumberMask' => string '************0821' (length=16)
  'customerName' => string 'Mr PHP Test' (length=11)
  'customerAddress' => string 'Flat 6
Primrose Rise
347 Lavender Road
Northampton' (length=50)
  'customerPostcode' => string 'NN17 8YG' (length=8)
  'customerPhone' => string '0845 00 99 575' (length=14)
  'customerEmail' => string 'support@cardstream.com' (length=22)
  'previousID' => string '6310462' (length=7)
  'xref' => string '14020712QS33TG46MX40GHQ' (length=23)
  'cardExpiryDate' => string '1215' (length=4)
  'authorisationCode' => string '271372' (length=6)
  'transactionID' => string '6310811' (length=7)
  'timestamp' => string '2014-02-07 12:33:46' (length=19)
  'amountReceived' => string '1050' (length=4)
  'avscv2ResponseCode' => string '422100' (length=6)
  'avscv2ResponseMessage' => string 'ADDRESS MATCH ONLY' (length=18)
  'avscv2AuthEntity' => string 'merchant host' (length=13)
  'cv2Check' => string 'not matched' (length=11)
  'addressCheck' => string 'matched' (length=7)
  'postcodeCheck' => string 'matched' (length=7)
  'cardTypeCode' => string 'VC' (length=2)
  'cardType' => string 'Visa Credit' (length=11)
  'currencyExponent' => string '2' (length=1)
  'settledTimestamp' => string '2014-02-07 12:33:46' (length=19)
  'responseStatus' => string '0' (length=1)
  'merchantName' => string 'CARDSTREAM TEST' (length=15)
  'merchantID2' => string '100001' (length=6)
  'signature' => string 'a114c25f4509ca65d9286e236ba4239cb5c7094781d77012ef4b1f08cb42ad42d7b4422af1a0da41a9b84e8b61da5435325311c0b859384e768e5a626bdd2d99' (length=128)
```
