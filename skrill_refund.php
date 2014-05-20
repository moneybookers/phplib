<?php
require_once 'lib/SkrillPSP.php';
try {
	// Create SkrillWallet Refund request object
	$refund = new SkrillPsp_SkrillWalletRefund("d2628d8b95904b03a15becf6a099bd16");

	// Set service endpoint
	$refund->setUri("https://psp.sandbox.dev.skrillws.net/v1/json/3e40a821/channelid/skrillwallet");
	
	//Set request parameters
    $refund->setParameters(array('identification' => array('transactionid' => 'RT126'),
                                 'payment' => array('amount' => '400', 'currency' => 'eur', 'descriptor' => 'wallet refund'),
        'account' => array('username' => 'ivan.govedarov@skrill.com', 'password'=>'3e9271f2213ccfba9149fbeeb2727d0c')
        ));	 
	
    // Allows you to view request in raw json format
    echo $refund->showJson();
    
    // Make SkirllWallet Refund call
	$result = $refund->makeCall();
        
        echo "<br>".$result->getJsonResponse();

	// Handle the response
	if($result->isSuccess()) {
		// success
            echo "Succes Here";
	}
	elseif ($result->isError()) {
		// error
            echo "Error";
	}
	elseif ($result->isErrorLevel()) {
		// error level
	}
	
	    if($result instanceof SkrillPsp_Response_Success) {
	    	 // success
                echo "Error 1";
	    }
	    elseif ($result instanceof SkrillPsp_Response_ErrorLevel)  {
	    	  // error level
                echo " Error 2";
	    }  
    
	
	
} 
catch (Exception $e) {
	
	 echo $e->getCode();
	 echo $e->getMessage();
}
