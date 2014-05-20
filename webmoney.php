<?php
require_once 'lib/SkrillPSP.php';
try {
	$web = new SkrillPsp_WebMoney();
	$web->setUri("https://psp.dev.skrillws.net/v1/json/3e40a821/testchannel_webmoney/webmoney");
    $web->setParameters(array('identification' => array('transactionid' => 'TY', 'customerid' => '5666'),
    		                  'payment' => array('amount' => '4444', 'currency' => 'EUR', 'country' => 'RU', 'descriptor' => 'Thghgh dhdhdh'),
                              'frontend' => array('language' => 'EN', 
                              		              'responseurl' => 'https://skrillbox.com/niliev/merchant/wpf_response.php', 
                              		              'successurl' => 'https://skrillbox.com/niliev/merchant/success_url.php',
                                                  'errorurl' => 'https://skrillbox.com/niliev/merchant/error_url.php', 
                              		              'cancelurl' => 'https://skrillbox.com/niliev/merchant/cancel_url.php'),
                              'customer' => array('contact' => array('email' => 'test@dir.bg', 'ip' => '129.0.0.10'))));  


  $web->setCancelUrl('http://www.gkgkg');
    echo $web->showJson();
	$result = $web->makeCall();
	var_dump($result);
    if($result->isSuccess()) {
    	 echo $result->getRedirectUrl();
    	 echo "<br />";
    	 echo $result->getTimeStamp();
    }
} catch (Exception $e) {
	echo $e->getMessage();
}