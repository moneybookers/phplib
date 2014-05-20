<?php
require_once 'lib/SkrillPSP.php';

try {
    $debit = new SkrillPsp_Debit("60938eb7bf0741e08ec220d6b3f24d7d");
    
    $debit->setMerchantUrl("https://psp.dev.skrillws.net/v1/json", "3e40a821", "channelid", "creditcard");
     
	$params = array('identification' => array('transactionid' => 'RTY6', 'customerid' => ''),
			'payment'  => array('amount' => '263', 'currency' => 'eur', 'descriptor' => ''),
			'account'  => array('cardholder' => 'Joe Dofof', 'number' => '4000000000000051', 'expiry' => '01/2015'),
			'customer' => array('name' => array('title' => 'Mrs', 'firstname' => 'Sarah', 'lastname' => 'Roly', 'company' => 'Cisco Systems'),
					            'address' => array('street' => 'Test stree', 'zip' => '1001', 'city' => 'Belêin', 'state' => 'BE', 'country' => 'DE'),
					            'contact' => array('phone' => '+4545454545', 'mobile' => '', 'email' => 'info@test', 'ip' => '122.255.255.255'))
	);
	
	$debit->setParameters($params);  
	
	
  //  $debit->setCVV('456');
	echo $debit->showJson();
	$result = $debit->makeCall();
	var_dump($result);
	echo $result->getJsonResponse();echo  "<br />";
	if($result instanceof SkrillPsp_Response_Success) {
		 echo $result->getTimeStamp();
	}
	elseif ($result instanceof SkrillPsp_Response_Error)
	{
		 echo $result->getErrorMessage();
	}
	elseif($result instanceof SkrillPsp_Response_ErrorLevel)
	{
		 echo $result->getId();
		 echo "<br />";
		 echo $result->getVersion();
		 echo "<br />";
		 echo $result->getErrorLevel(); echo "<br />";
		 echo $result->getErrorCode(); echo "<br />";
		 echo $result->getMethod(); echo "<br />";
		 echo $result->getType(); echo "<br />";
		 echo $result->getErrorMessage();echo "<br />";
		 echo $result->getAdvice(); echo "<br />";
		 var_dump($result->getIdentification());
	} 
/*	if($result->isSuccess()) {
		 echo $result->getReferenceId();
	}
	elseif ($result->isError()) {
		 echo $result->getErrorMessage();
	}
	elseif ($result->isErrorLevel()) {
		echo $result->getAdvice();
	}*/
	
}
catch(SkrillPsp_Exception $e) {
	echo $e->getMessage();
	echo $e->getTraceAsString();
}

