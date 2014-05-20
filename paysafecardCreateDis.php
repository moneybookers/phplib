<?php
require_once 'lib/SkrillPSP.php';

try {
	$pay = new SkrillPsp_PaySafeCardCreateDisposition();
	$pay->setUri("https://psp.dev.skrillws.net/v1/json/3e40a821/channelid_psc_psp/paysafecard");
	$pay->setParameters(array('identification' => array('transactionid' => 'TY565661', 'customerid' => '5677'),
			'payment' => array('amount' => 5656, 'currency' => 'EUR'),
			'account' => array('locale' => 'fr_fr', 'kyclevel' => '', 'minage' => '56', 'shopid' => '3434', 'shoplable' => 'shfhfh', 'country' => 'de'),
			'frontend' => array('responseurl' => 'http://mercgh/response.php', 'successurl' => 'http://merchant/success.php',
					'errorurl' => 'http://merchant/error.php'),
			        'customer' => array('name' => array('salutation' => 'Mr', 'title' => 'Dr', 'given' => 'Ftrst', 'family' => 'Gggg', 'company' => 'Skrill'),
					'address' => array('street' => '12 Some', 'zip' => '1234', 'city' => 'aa', 'state' => 'dfdfdf', 'country' => 'DE'),
			        'contact' => array('email' => 'test@dir.bg', 'ip' => '125.6.6.0'))));
	
	echo $pay->showJson();

	$result = $pay->makeCall();
	var_dump($result);
	if($result->isSuccess()) {
		echo $result->getRedirectUrl();
		echo "<br />";
		echo $result->getMethod();
		echo $result->getTimeStamp();
		echo $result->getJsonResponse();
		echo $result->getJsonResponse();
	}
} catch (SkrillPsp_Exception $e) {
	echo $e->getMessage();
}
