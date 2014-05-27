<?php
require 'lib/SkrillPSP.php';

try {
	$tab = new OneTap_Debit("ea7f9a12fe114b2d8f9ea99e181173e1");
	$tab->setUri("https://psp.sandbox.dev.skrillws.net/v1/json/3e40a821/channelid/skrillwallet");
	
	$tab->setParameters(array('identification' => array('transactionid' => 'Ty69696', 'customerid' => '68668'),
                                         'account' => array('username' => 'ivan.govedarov@skrill.com', 'password'=>'3e9271f2213ccfba9149fbeeb2727d0c'),
			                 'payment' => array('amount' => '100', 'currency' => 'eur', 'descriptor' => 'jdjdjd')));
	echo $tab->showJson();
	$result = $tab->makeCall();
	var_dump($result);
} 
catch (Exception $e) {
     echo $e->getMessage();
}