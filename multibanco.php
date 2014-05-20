<?php
require_once 'lib/SkrillPSP.php';

try {
     $multi = new SkrillPsp_Multibanco();
     
     $multi->setUri("https://psp.dev.skrillws.net/v1/json/3e40a821/testchannel_multibanco/multibanco");
     
     $multi->setParameters(array('identification' => array('transactionid' => 'Nfhr', 'customerid' => 'sdsds'),
                                 'payment'  => array('amount' => '07', 'currency' => 'EUR', 'country' => 'PT', 'descriptor' => 'descriptor'),
                                 'frontend' => array('language' => 'en', 
                                 		             'responseurl' => 'https://skrillbox.com/niliev/merchant/wpf_response.php', 
                                 		             'successurl' => 'https://skrillbox.com/niliev/merchant/success_url.php',
                                 		             'errorurl' => 'https://skrillbox.com/niliev/merchant/error_url.php'),
                                 'customer' => array('contact' => array('email' => 'hansi_mueller123@skrill.com', 'ip' => '127.0.0.10')),
                                 )
                           );
   
     
     echo $multi->showJson();	
     $result = $multi->makeCall();
     var_dump($result);
     if($result->isSuccess()) {
     	 echo $result->getRedirectUrl();
     	 echo "<br />" . $result->getTimeStamp();
     }
     else {
     	  
     }
     
} 
catch (Exception $e) {
	
   echo $e->getMessage();
}