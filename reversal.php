<?php
require_once 'lib/SkrillPSP.php';

try {
    $reversal = new SkrillPsp_Reversal();
    $reversal->setMerchantUrl("https://psp.dev.skrillws.net/v1/json", "3e40a821", "channelid", "creditcard");
    $reversal->setParameters(array('identification' => array('transactionid' => '6768', 'customerid' => 23, 'referenceid' => '9028162d176d4174b610aaafb89d1a7c')));

     echo $reversal->showJson();
     $result = $reversal->makeCall();
     var_dump($result);	
} 
catch (SkrillPsp_Exception $e) {
	echo $e->getMessage();
}
