<?php
require_once 'lib/SkrillPSP.php';

try {
	$preauth = new SkrillPsp_Preauthorization();
	$preauth->setMerchantUrl("https://psp.dev.skrillws.net/v1/json", "3e40a821", "channelid", "creditcard");
	
	$preauth->setParameters(array('identification' => array('transactionid' => '', 'customerid' => 'Tyjyjyj'),
			                      'payment' => array('amount' => '157', 'currency' => 'eur', 'descriptor' => 'tyyyh'),
			                      'account' => array('cardholder' => 'Tony Nony', 'number' => '4000000000000051', 'expiry' => '12/2015', 'cvv' => '566'),
	                              'customer' => array('name' => array('title' => 'Mr', 'firstname' => 'Rthht', 'lastname' => 'Rehdh', 'company' => 'Rgjgj'),
	                                                   'address' => array('street' => 'Rfhfhfh', 'zip' => '56ttt', 'city' => 'Berlin', 'state' => '', 'country' => 'DE'),
	                                                   'contact' => array('phone' => '+343434388', 'mobile' => '+3574747488', 'email' => 'in@in.de', 'ip' => '127.10.1.2'))
	)); 
	
	echo $preauth->showJson();
	echo intval(05, 8);
	$result = $preauth->makeCall();
	var_dump($result);
	//echo $result->getReferenceId();
	if($result->isError())
	{
	//	 echo $result->getLevel();
		 echo $result->getErrorLevel();
		 echo "<br />";
		 echo $result->getErrorCode();
	/*	 $data = $result->getError();
		 echo $data->code;
		 echo $data->message;
		 $errorData = $result->getErrorData();
		 echo $result->getAdvice();
		 echo "<br />" . $result->getErrorDataMessage();
		 echo "<br />" . $result->getErrorLevel();
		 echo "<br />" . $result->getErrorCode();
		 echo "<br />" . $result->getErrorMessage();  */
		 echo $result->getJsonResponse();
	}
        
	
} catch (SkrillPsp_Exception $e) {
	echo $e->getMessage();
}