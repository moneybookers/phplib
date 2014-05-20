<?php
require_once 'lib/SkrillPSP.php';

try {
	$obj = new SkrillPsp_iDEAL();
	$obj->setUri("https://psp.dev.skrillws.net/v1/json/3e40a821/testchannel_ideal/ideal");

     $obj->setParameters(array('identification' => array('transactionid' => 'MerchntAsignedID', 'customerid' => 'CustomerID'), 
                             'payment' => array('amount' => '107', 'currency' => 'eur', 'descriptor' => 'commet'),
   		                     'account' => array('issuerid' => 'INGBNL2A'),
   		                     'frontend' => array('language' => 'NL','responseurl' => 'https://pancho.skrillbox.com/bernhard/response.json.php', 'successurl' => 'https://ibm.com', 'errorurl' => 'https://error.com'),
                             'customer' => array('name' => array('firstname' => 'jfjfjfjf', 'company' => 'Skrill LTD', 'lastname' => 'Gfjfjfj', 'salutation' => 'Mr'),
                                                 'address' => array('street' => 'Ggjgjjg', 'zip' => '6778', 'city' => 'Pernik', 'country' => 'BG'),
                                                 'contact' => array('email' => 'inf@fi.de', 'ip' => '127.0.0.15'))));   

    // Allows you to view json request
	echo $obj->showJsonDirectory();
	
	$result = $obj->createDirectory();
	
	if($result->isSuccess()) {
		 $issuerid = $result->directory;
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