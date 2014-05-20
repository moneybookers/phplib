<?php
// include library
require_once '../lib/SkrillPSP.php';

// the flow is the same for other type of requests

try {
	// create request object with or without token for credit/debit request
	// you can provide token as constructor parameter
	// $debit = new SkrillPsp_Debit("58409c4a39a94cf4bd3fe07647fca9fd");
	// If you don't provide token you must provide card details (cardholder, number, exp. date, cvv)
	$debit = new SkrillPsp_Debit();
	
	// Set service end point via SkrillPSP::setMerchant() or SkrillPSP::setUri()
	$debit->setMerchantUrl("https://psp.dev.skrillws.net/v1/json", "3e40a821", "channelid_3d", "creditcard");
	//$debit->setUri("https://psp.dev.skrillws.net/v1/json/3e40a821/channelid_3d/creditcard");
	
	// Set required parameters through the setters or SkrillPsp::setParameters() method
	// You can use setParameters method and set all parameters at once instead of each one of set.XXX methods 
	// setParameters method can save you typing in return for clearness
  /*	$debit->setTransactionId("Ckdkd12")
	      ->setCustomerId("39393993")
	      ->setAmount("457")
	      ->setCurrency("EUR")
	      ->setDescriptor("sdsd")
	      ->setCardholder("Dkdk Dkfkf")
	      ->setCardNumber("4000000000000051")
	      ->setExpiryDate("12/2015")
	      ->setCVV(122)
	      ->setTitle("Mr.")
	      ->setFirstName('Ibrahim')
	      ->setLastName('Musa')
	      ->setCompany('Cicso')
	      ->setStreet('Saddam Husein')
	      ->setZip('1001')
	      ->setCity('Bagd')
	      ->setState('dldldld')
	      ->setCountry('US')
	      ->setPhone('202020202')
	      ->setMobile('+390303030303')
	      ->setEmail('nbn313@yahoo.com')
	      ->setIpAddress('127.1.0.0');  */

	      $params = array('identification' => array('transactionid' => 'CRM_F56A', 'customerid' => '122456'),
	      		'payment'  => array('amount' => '128', 'currency' => 'USD', 'descriptor' => 'grgrg'),
	      		'account'  => array('cardholder' => 'Gkgkgk', 'number' => '4000000000000051', 'expiry' => '01/2015', 'cvv' => '123'),
	       		'customer' => array('name' => array('title' => 'Mrs', 'firstname' => 'Sarah', 'lastname' => 'Roly', 'company' => 'Cisco Systems'),
	      				'address' => array('street' => 'Test stree', 'zip' => '1001', 'city' => 'Berlin', 'state' => 'BE', 'country' => 'DE'),
	      				'contact' => array('phone' => '+4545454545', 'mobile' => '', 'email' => 'info@test', 'ip' => '122.20.20')), 
	      		'merchant' => array('key' => 'value4545')
	      );
	      
	      $debit->setParameters($params); 
	  // addParameters allows you to augment the predefined request parameters  
	    $debit->addParameters(array('frontend' => array('responseurl' => 'http://resp.php', 'successurl' => 'http://success.php', 'errorurl' => 'http://error.php')));
	    $debit->addParameters(array('India' => array('city' => 'Hyderabad')));
	     
	// You can check builded request through showJson method before or after make call
	  echo $debit->showJson();
	
	// send request and save the response
	$result = $debit->makeCall();
	var_dump($result);
    // check response object for success or error accordingly
	if($result->isSuccess()) { 
		// work with result method and properties
	    $identity = $result->getIdentification();	
	    $payment = $result->getPayment();
	    echo $token = $result->getTokenFromAccount();
	    echo $result->type;
	    echo "<br />";
	    echo $result->message;
	    echo "<br />";
	    echo $result->method;
	  //  echo $result->getId();
	  //  echo $result->getVersion();
	  echo $result->getCode();
	  echo "<br />";
	  echo $result->getLevel();
	}
	else {
	     // work with error data 
		 $data = $result->getErrorData();
		 $errorData = $result->getError();
		 var_dump($data);
		 echo $errorData->code;
		 echo $errorData->message;
		 echo $result->getErrorLevel();
		 echo "<br />";
		 echo $result->getErrorMessage();
		 echo $result->getErrorCode();
		 echo $result->getErrorDataMessage();
		 echo $result->getId();
		 echo "<br />";
		 foreach ($data as $val)
		 {
		 	  echo "$val<br />";
		 }
		 
	}
} catch (SkrillPsp_Exception $e) {
	echo $e->getMessage();
}