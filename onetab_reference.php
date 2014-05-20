<?php
require 'lib/SkrillPSP.php';

try {
	$tab = new OneTab_ReferenceTransaction("5504eaee2ef54e369ba620cb716426f1");
	$tab->setUri("https://psp.dev.skrillws.net/v1/json/3e40a821/channelid_skrillwallet/skrillwallet");
	
	$tab->setParameters(array('identification' => array('transactionid' => 'Ty69696', 'customerid' => '68668'),
			                 'payment' => array('amount' => '100', 'currency' => 'eur', 'descriptor' => 'jdjdjd')));
	echo $tab->showJson();
	$result = $tab->makeCall();
	var_dump($result);
} 
catch (Exception $e) {
     echo $e->getMessage();
}