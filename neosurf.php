<?php
require_once 'lib/SkrillPSP.php';

try {
	
	$neosurf = new SkrillPsp_Neosurf();
	$neosurf->setUri("https://api.nextgenp.com/merchants/zmcdptfj8kv9fwhj/testchannel_envoy/envoy");
	$neosurf->setParameters(array('identification' => array('transactionid' => 'TY45', 'customerid' => '575775'),
	                              'payment' => array('amount' => '576', 'currency' => 'EUR', 'country' => 'BE', 'descriptor' => 'descriptior'),
	                              'frontend' => array('language' => 'EN', 'responseurl' => 'http://merchant/response.php', 'successurl' => 'http://merchant/success.php',
	                              		               'errorurl' => 'http://merchant/error.php'),
	                              'customer' => array('contact' => array('email' => 'hansi_mueller123@skrill.com', 'ip' => '127.0.0.1'))));
	echo $neosurf->showJson();
	$result = $neosurf->makeCall();
	if($result->isSuccess()) {
		 echo $result->getRedirectUrl(); 
		 echo $result->getTimeStamp();
	}
	
} catch (SkrillPsp_Exception $e) {
	echo $e->getMessage();
	echo $e->getCode();

}