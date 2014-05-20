<?php
// include library
require_once '../lib/SkrillPSP.php';

// the flow is the same for other types of request

try {
	// Create request object with referenceID for refund/capture/reversal request
	$reversal = new SkrillPsp_Reversal("7327dc483f8e435fb549c3a27f961541");

	// Set service end point via SkrillPSP::setMerchant() or SkrillPSP::setUri()
	 $reversal->setMerchantUrl("https://psp.dev.skrillws.net/v1/json", "3e40a821", "channelid_3d", "creditcard");
	// $reversal->setUri("https://psp.dev.skrillws.net/v1/json/3e40a821/channelid_3d/creditcard");
	 
	// Set required parameters through the setters or SkrillPsp::setParameters() method
	// You can use setParameters method and set all parameters at once instead of each one of set.XXX methods obe after another
	// setParameters method can save you typing in return for clearness
	 $reversal->setParameters(array('identification' => array('transactionid' => 'Thk13', 'customerid' => '12222', 'referenceid' => 'Rjrjrj4747474747')));
	 
/*	 $reversal->setTransactionId("TG_9399393939")
	          ->setCustomerId('456'); */
	 
	 // You can check builded request through showJson method before or after make call
	 echo $reversal->showJson();
	
	 // send request and save the response
	 $result = $reversal->makeCall();
	 
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
catch (Exception $e) {
	echo $e->getMessage();
}