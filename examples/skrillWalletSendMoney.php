<?php
require_once 'lib/SkrillPSP.php';

try {
	// Create SkrillWallet SendMoney request object
	$send = new SkrillPsp_SkrillWalletSendMoney();

	// Set service endpoint
	$send->setUri('https://psp.dev.skrillws.net/v1/json/3e40a821/channelid_skrillwallet/skrillwallet');

	//Set request parameters
	$send->setParameters(array('identification' => array('transactionid' => 'TY', 'customerid' => 'htht'),
			'payment' => array('amount' => '203', 'currency' => 'eur', 'subject' => 'Ghkhkhk', 'note' => 'tets'),
			'customer' => array('contact' => array('email' => 'nb@di.nf', 'ip' => '127.0.0.1'))));
	
	// Allows you to view request in raw json format
	echo $send->showJson();
	
	// Make SkrillWallet Send Money request
	$result = $send->makeCall();
	
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
	
} 

catch (SkrillPsp_Exception $e) {
	echo $e->getMessage();
}