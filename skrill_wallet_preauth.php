<?php
require_once 'lib/SkrillPSP.php';

try {
$obj = new SkrillPsp_SkrillWalletPreauthorization();
$obj->setUri("https://psp.sandbox.dev.skrillws.net/v1/json/3e40a821/channelid/skrillwallet");


$obj->setParameters(array('identification' => array('transactionid' => '', 'customerid' => ''),
                          'payment' => array('amount' => '500', 'currency' => 'EUR', 'descriptor' => '', 'payment_methods' => array()), 
                          'account' => array('username' => 'mb654@abv.bg', 'password'=>'' ),
		                  'frontend' => array('responseurl' => 'http://www.skrillbox.com/presta/modules/skrillwpf/validation.php',
		                  		              'successurl' => array('url' => 'http://www.ibm.com', 'text' => 'sOFIA', 'target' => '4'),
                                              'errorurl' => array('url' => 'https://www.skrillbox.com/niliev/merchant/error_url.php', 'target' => '3'), 
		                  		              'amount_details' => array(array(184, "Product payment"), array(345, 'Plflfl')),    // must be array of arrays
		                  		              'language' => 'DE', 
		                                      'new_window_redirect' => '1', 
		                  		              'ext_ref_id' => '', // opt
		                                      'confirmation_note' => 'fdhfhhf fhfhfhfh',  // optional
		                                      //'logo_url' => 'https://www.skrill.com/uploads/pics/homepage-slider-04_01.png', // opt
		                                      'rid' => '2323', 
		                  		              'detail_descriptions' => array(array('detail description', 'detail text')) // must be array of arrays
		                                       ),
		                  
                           'customer' => array('name' => array('firstname' => 'nick', 'lastname' => 'nick'),
                           		               'address' => array('street' => 'Tets strr', 'zip' => '45454', 'city' => 'Berlin', 'country' => 'DE'),
                           		               'contact' => array('email' => '', 'ip' => '124.0.0.12')
                                         ),
                          'merchant' => array('key1' => 'value', 'key2' => 'value1', 'key3' => 'value2', 'key4' => 'value3')
                            ));

//$obj->setFrontendSuccessUrl(array('url' => 'fpt://fkfkfkf.com', 'text' => 'Varna', 'target' => '3')); 
;
//$valid = $obj->emailChecker($url, "mbcust4321@abv.bg");
//var_dump($valid);



echo $obj->showJson();
$result = $obj->makeCall();
//var_dump($result);
echo $result->getJsonResponse();
   if($result->isSuccess()) {
   	   echo "<BR><BR><a href='".$result->getRedirectUrl()."'>".$result->getRedirectUrl()."</a><BR><BR>";
   	   //var_dump($result->getLevel());
   	   echo $result->getJsonResponse();
   } 
//   echo $result->getJsonResponse();

}

catch (Exception $e)
{
	  echo $e->getMessage();
	  echo $e->getTraceAsString();
}