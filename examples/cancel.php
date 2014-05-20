<?php
// include library
require_once '../lib/SkrillPSP.php';

// the flow is the same for other types of request
try {
	// Create request object with referenceID for refund/capture/reversal request
	$cancel = new SkrillPsp_Cancel("06e9285f1d454fdca322c448ada48d5e");
	
	// Set service end point via SkrillPSP::setMerchant() or SkrillPSP::setUri()
	$cancel->setMerchantUrl("https://psp.dev.skrillws.net/v1/json", "3e40a821", "channelid_3d", "creditcard");
	// $cancel->setUri("https://psp.dev.skrillws.net/v1/json/3e40a821/channelid_3d/creditcard");
	
	// Set required parameters through the setters or SkrillPsp::setParameters() method
	// You can use setParameters method and set all parameters at once instead of each one of set.XXX methods obe after another
	// setParameters method can save you typing in return for clearness
	$cancel->setParameters(array('identification' => array('transactionid' => 'ed24b0c5f31d44fa995f4b6a8540e489', 'referenceid' => 'Rjrjrj4747474747'),
	                             'payment' => array('amount' => '456', 'currency' => 'USD', 'descriptor' => 'ghhghg, jfjfjjf')));
	 
  /*  $cancel->setTransactionId("TG_9399393939")
                ->setAmount("333")
                ->setCurrency('GBP')
                ->setDescriptor('Dddjjd');  */
	
	// You can check builded request through showJson method before or after make call
	echo $cancel->showJson();
	
	// send request and save the response
	$result = $cancel->makeCall();
	var_dump($result);
	
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