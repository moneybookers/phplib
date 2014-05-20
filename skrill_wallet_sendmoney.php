<?php
require_once 'lib/SkrillPSP.php';

try {
	$send = new SkrillPsp_SkrillWalletSendMoney();
	
	$send->setUri('https://psp.sandbox.dev.skrillws.net/v1/json/3e40a821/channelid/skrillwallet');
	
	$send->setParameters(array('identification' => array('transactionid' => 'TY', 'customerid' => 'htht'),
	                           'payment' => array('amount' => '203', 'currency' => 'eur', 'subject' => 'Ghkhkhk', 'note' => 'tets'),
                               'account' => array('username' => 'ivan.govedarov@skrill.com', 'password'=>'3e9271f2213ccfba9149fbeeb2727d0c'),
                               'frontend' => array('responseurl' => 'http://www.skrillbox.com/presta/modules/skrillwpf/validation.php'),
	                           'customer' => array('contact' => array('email' => 'mb123@abv.bg', 'ip' => '127.0.0.1'))));
	echo $send->showJson();
    $result = $send->makeCall();

    echo $result->getJsonResponse();

    var_dump($result);
} 

catch (Exception $e)
{
	  echo $e->getMessage();
	  echo $e->getTraceAsString();
}

