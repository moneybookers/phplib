<?php
// include library
require_once '../lib/SkrillPSP.php';

// the flow is the same for other types of request
try {
	// Create request object
	$register = new SkrillPsp_Register();	
	
	// Set service end point via SkrillPSP::setMerchant() or SkrillPSP::setUri()
	$register->setMerchantUrl("https://psp.dev.skrillws.net/v1/json", "3e40a821", "channelid_3d", "creditcard");
	// $preauth->setUri("https://psp.dev.skrillws.net/v1/json/3e40a821/channelid_3d/creditcard");	
	
	// Set required parameters through the setters or SkrillPsp::setParameters() method
	// You can use setParameters method and set all parameters at once instead of each one of set.XXX methods obe after another
	// setParameters method can save you typing in return for clearness
	$params = array('account'  => array('number' => '4000000000000051', 'expiry' => '01/2015', 'cvv' => '123'));
	$register->setParameters($params);
	
/*	$register->setCardNumber("4000000000000002")
	         ->setExpiryDate('12/2015')
	         ->setCVV("111"); */
	
	// You can check builded request through showJson method before or after make call
	echo $register->showJson();
	
	// send request and save the response
	$result = $register->makeCall();

	// check response object for success or error accordingly
	if($result->isSuccess()) {
		// work with result method and properties
		$identity = $result->getIdentification();
		$payment  = $result->getPayment();
		echo $result->type;
		echo $result->message;
		echo $result->level;
	}
	else {
		// work with error data
		$data = $result->getErrorData();
		$errorData = $result->getError();
	}
} 
catch (SkrillPsp_Exception $e) {
	echo $e->getMessage();
}