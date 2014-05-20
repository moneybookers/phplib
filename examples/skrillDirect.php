<?php
require_once 'lib/SkrillPSP.php';

try {
	// Create SkrillDirect request object
	$skrill = new SkrillPsp_SkrillDirect();
	
	// Set service endpoint
	$skrill->setUri("https://psp.dev.skrillws.net/v1/json/3e40a821/channelid_skrilldirect/skrilldirect");

	// Set request parameters
	$skrill->setParameters(array('payment' => array('amount' => '112', 'currency' => 'EUR', 'descriptor' => 'hjhjhjh', 'recipient' => ''),
			'account' => array('holder' => 'Tgjgjgjg', 'accountnumber' => '797979', 'routingnumber' => '6767676'),
			'frontend' => array('responseurl' => 'http://test/merchant.php', 'successurl' => 'http://test/success.php', 'errorurl' => 'http://merhc/error.php'),
			'customer' => array('name' => array('firstname' => 'Tgogog', 'lastname' => 'Tgkgkg'),
					'address' => array('street' => 'Fkfkfkfkf', 'zip' => '34343', 'city' => 'Berlin', 'country' => 'DE'),
					'contact' => array('email' => 'in@in.de', 'ip' => '124.20.2.2'))));
	
	// Allows you to view request in raw json format
	echo $skrill->showJson();
	
	// Make SkrillDirect request
	$result = $skrill->makeCall();
	
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

} catch (SkrillPsp_Exception $e) {
	echo $e->getMessage();
}