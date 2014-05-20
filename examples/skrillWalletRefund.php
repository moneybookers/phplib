<?php
require_once 'lib/SkrillPSP.php';
try {
	// Create SkrillWallet Refund request object
	$refund = new SkrillPsp_SkrillWalletRefund("b1d73bcc164f452c9f9bcbfe82a948f0");

	// Set service endpoint
	$refund->setUri("https://psp.dev.skrillws.net/v1/json/3e40a821/channelid_skrillwallet/skrillwallet");

	//Set request parameters
	$refund->setParameters(array('identification' => array('transactionid' => 'RT126'),
			'payment' => array('amount' => '600', 'currency' => 'eur', 'descriptor' => 'wallet refund')));

	// Allows you to view request in raw json format
	echo $refund->showJson();

	// Make SkirllWallet Refund call
	$result = $refund->makeCall();

	// Handle the response
	if($result->isSuccess()) {
		// success
	}
	elseif ($result->isError()) {
		// error
	}
	elseif ($result->isErrorLevel()) {
		// error level
	}

	if($result instanceof SkrillPsp_Response_Success) {
		// success
	}
	elseif ($result instanceof SkrillPsp_Response_ErrorLevel)  {
		// error level
	}



}
catch (Exception $e) {

	echo $e->getCode();
	echo $e->getMessage();
}