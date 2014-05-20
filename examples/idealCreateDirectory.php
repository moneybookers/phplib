<?php
require_once 'lib/SkrillPSP.php';

try {
	// Create iDEAL request object
	$obj = new SkrillPsp_iDEAL();
	
	// Set service endpoint
	$obj->setUri("https://psp.dev.skrillws.net/v1/json/3e40a821/testchannel_ideal/ideal"); 

    // Allows you to view request in raw json format
	echo $obj->showJsonDirectory();
	
	// Make iDEAL directory request
	$result = $obj->createDirectory();
	
	// Handle the response
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