<?php 
require_once 'lib/SkrillPSP.php';

try {
	// Create iDEAL request object
	$obj = new SkrillPsp_iDEAL();
	
	// Set service endpoint
	$obj->setUri("https://psp.dev.skrillws.net/v1/json/3e40a821/testchannel_ideal/ideal");

	// Set request parameters
	$obj->setParameters(array('identification' => array('transactionid' => 'MerchntAsignedID', 'customerid' => 'CustomerID'),
			'payment' => array('amount' => '107', 'currency' => 'eur', 'descriptor' => 'commet'),
			'account' => array('issuerid' => 'INGBNL2A'),
			'frontend' => array('language' => 'NL','responseurl' => 'https://pancho.skrillbox.com/bernhard/response.json.php', 'successurl' => 'https://ibm.com', 'errorurl' => 'https://error.com'),
			'customer' => array('name' => array('firstname' => 'jfjfjfjf', 'company' => 'Skrill LTD', 'lastname' => 'Gfjfjfj', 'salutation' => 'Mr'),
					'address' => array('street' => 'Ggjgjjg', 'zip' => '6778', 'city' => 'Pernik', 'country' => 'BG'),
					'contact' => array('email' => 'inf@fi.de', 'ip' => '127.0.0.15'))));

	// Allows you to view request in raw json format
	echo $obj->showJson();

	// Make iDEAL PA request
	// With one iDEAL request object one can make createDirectory and createPreAuthorization requests
	// $dir = $obj->createDirectory();
	$result = $obj->createPreAuthorization();

	// Handle the response
	if($result->isSuccess()) {
		$url = $result->getRedirectUrl();
		$time = $result->getTimeStamp();
	}
	elseif ($result->isError()) {
		// error
	}
	elseif ($result->isErrorLevel()) {
		// error level
	}
}
catch (Exception $e) {
	echo $e->getMessage();
}
?>
