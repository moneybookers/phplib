<?php
require_once 'lib/SkrillPsp.php';

try {
      $refund = new SkrillPsp_Refund("0e0e6917091a4a0f8c4eeffcb4d60bed");
      $refund->setMerchantUrl("https://psp.dev.skrillws.net/v1/json", "3e40a821", "channelid", "creditcard");
      $params = array('identification' => array('transactionid' => 'CRMF56A', 'customerid' => '122456'),
      		'payment'  => array('amount' => '130', 'currency' => 'eur', 'descriptor' => 'tytyty'),
     
      );
      
      $refund->setParameters($params);
    //  $refund->setCurrency("GBP");
    $refund->setCustomerId("56565");
      echo $refund->showJson();
      $result = $refund->makeCall();
      var_dump($result);
	  echo $result->getErrorCode();
      if($result->isSuccess())
      {
      	  $identification = $result->getIdentification();
      	  var_dump($identification);  
   
      	  echo $result->getLevel();
      	  echo "<br />" . $result->getCode();
      	  echo "<br />" . $result->getMethod();
      	  echo "<br />" . $result->getRequestType();
      	  echo "<br />" . $result->getMessage();
      	  echo "<br />" . $result->getAdvice();
      	  echo $result->code; echo $result->level; echo $result->message;
      	  echo $result->getJsonResponse();
      }  
      echo $result->getJsonResponse();
      echo $result->getIdentification();
}
catch (SkrillPsp_Exception $e)
{
	echo $e->getCode();
	echo $e->getMessage();
	echo $e->getTraceAsString();
}