<?php
require_once 'lib/SkrillPSP.php';
try {
	
	$register = new SkrillPsp_Register();
	$register->setMerchantUrl("https://psp.dev.skrillws.net/v1/json", "3e40a821", "channelid", "creditcard");
	$register->setUri("https://psp.dev.skrillws.net/v1/json/3e40a821/channelid_register_get/creditcard");
	
	$params = array('account'  => array('number' => '4000000000000051', 'expiry' => '10/2015')
	);
	
	$register->setParameters($params);
	echo $register->showJson();
	$result = $register->makeCall();
    var_dump($result);
	if($result->isSuccess())
	{
    /*   echo $result->getToken();
         echo "<br />";
         echo $result->getBin();
         echo "<br />";
         echo $result->getLast();
         echo "<br />";
         echo $result->getExpiryMonth();
         echo "<br />";
         echo $result->getExpiryYear();
         echo "<br />";
         echo $result->getMasked(); */
         
         echo $result->getReferenceId();
         
         foreach ($result->getAccount() as $val)
         {
         	   echo "$val<br />";
         }
     
	}
	
	if($result instanceof SkrillPsp_Response_Error) {
		echo $result->getJsonResponse();
	}
	if($result instanceof SkrillPsp_Response_ErrorLevel) {
		echo $result->getJsonResponse();
	}
}
catch (SkrillPsp_Exception $e)
{
	 echo $e->getMessage();
}