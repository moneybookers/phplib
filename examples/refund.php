<?php
// include library
require_once '../lib/SkrillPSP.php';

// the flow is the same for other types of request

try {
	// Create request object with referenceID for refund/capture/reversal request
	$refund = new SkrillPsp_Refund("c21a0ef567a14d7bad56582099f9f7c8");
	
	// Set service end point via SkrillPSP::setMerchant() or SkrillPSP::setUri()
	$refund->setMerchantUrl("https://psp.dev.skrillws.net/v1/json", "3e40a821", "channelid_3d", "creditcard");
	// $credit->setUri("https://psp.dev.skrillws.net/v1/json/3e40a821/channelid_3d/creditcard");
	
	// Set required parameters through the setters or SkrillPsp::setParameters() method
	// You can use setParameters method and set all parameters at once instead of each one of set.XXX methods obe after another
	// setParameters method can save you typing in return for clearness
	// addParameters allows you to augment the predefined request parameters
	$params = array('identification' => array('transactionid' => 'CRM_F56A', 'customerid' => '122456'),
			        'payment'  => array('amount' => '122', 'currency' => 'EUR', 'descriptor' => 'grgrg'),		 
	);
	$refund->setParameters($params);
	 
	/**
	 * Set methods
	 * <code>
	 *  	$refund->setTransactionId("CRG_45")
	 *             ->setCustomerId('22222')
	 *             ->setAmount(455)
	 *             ->setCurrency('USD')
	 *             ->setDescriptor("dkdkdk dkdk");
	 * </code>
	 */
	
	// You can check builded request through showJson method before or after make call
	echo $refund->showJson();
	
	// send request and save the response
	$result = $refund->makeCall();
	
	// check response object for success or error accordingly
	if($result->isSuccess()) {
		// work with result method and properties
		$identity = $result->getIdentification();
		$payment = $result->getPayment();
		echo $result->type;
		echo $result->message;
	}
	else {
		// work with error data
		$data = $result->getErrorData();
		$errorData = $result->getError();
	}
	
} catch (SkrillPsp_Exception $e) {
	echo $e->getMessage();
}