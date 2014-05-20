<?php
require_once 'lib/SkrillPSP.php';

try {
    $lobanet = new SkrillPsp_Lobanet();
    $lobanet->setUri("https://psp.dev.skrillws.net/v1/json/3e40a821/testchannel_lobanet/lobanet");
    $lobanet->setParameters(array('identification' => array('transactionid' => '3434', 'customerid' => '676767'),
                                  'payment' => array('amount' => '4545', 'currency' => 'UYU', 'country' => 'UY', 'descriptor' => 'kdkdkdk'),
                                  'frontend' => array('language' => 'EN', 'responseurl' => 'http://merc/resp.php', 'successurl' => 'https://skrillbox.com/niliev/merchant/wpf_response.php',
                                                      'errorurl' => 'http://merchant/error.php'),
                                   'customer' => array('contact' => array('email' => 'test@dir.bg', 'ip' => '127.0.0.10')
                                                  )));
    echo $lobanet->showJson();	
    $result = $lobanet->makeCall();
    var_dump($result);
    if($result->isSuccess()) {
    	echo $result->getRedirectUrl();
    	echo "<br />" . $result->getTimeStamp();
    }
    else {
    
    }
} 
catch (SkrillPsp_Exception $e) {
	
	 echo $e->getMessage();
}