<?php
require_once 'lib/SkrillPSP.php';

try {
	// Create Paysafecard request object
	$pay = new SkrillPsp_PaySafeCardPA();

	// Set service endpoint
	$pay->setUri("https://psp.dev.skrillws.net/v1/json/3e40a821/channelid_psc_psp/paysafecard");

	// Set request parameters
	$pay->setParameters(array('identification' => array('transactionid' => '', 'customerid' => ''),
			'payment' => array('amount' => '56', 'currency' => 'eur'),
			'account' => array('country_restriction' => '', 'kyclevel' => ''),
			'frontend' => array('responseurl' => 'http://mercgh/response.php', 'successurl' => 'http://merchant/success.php',
					'errorurl' => 'http://merchant/error.php'),
			'customer' => array('name' => array('salutation' => 'Mr', 'title' => 'Dr', 'given' => '', 'family' => '', 'company' => ''),
					'address' => array('street' => '12 Some', 'zip' => '1234', 'city' => 'aa', 'state' => 'dfdfdf', 'country' => 'DE'),
					'contact' => array('email' => 'in@in.fr', 'ip' => '123.255.255.255'))));
	
	// Allows you to view request in raw json format
	echo $pay->showJson();

	// Make Paysafecard request
	$result = $pay->makeCall();

	// Handle the response
	if($result->isSuccess()) {
		echo $result->getRedirectUrl();
		echo "<br />";
		echo $result->getMethod();
		echo $result->getTimeStamp();
		echo $result->getJsonResponse();
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