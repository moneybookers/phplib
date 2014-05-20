<?php
require_once 'lib/SkrillPSP.php';

try {
	$tab = new OneTab_Status("5504eaee2ef54e369ba620cb716426f1");
	$tab->setUri("https://psp.dev.skrillws.net/v1/json/3e40a821/channelid_skrillwallet/skrillwallet");
	$tab->setParameters(array('identification' => array('transactionid' => 'TYYY', 'customerid' => 'HJJJ67')));
	echo $tab->showJson();
	$result = $tab->makeCall();
	var_dump($result);
	echo $result->getJsonResponse();
	
} catch (Exception $e) {
	 echo $e->getMessage();
}