<?php
require_once 'lib/SkrillPSP.php';

$capture = new SkrillPsp_Capture("594025595bbb482689af128e122ca672");
$capture->setMerchantUrl("https://psp.dev.skrillws.net/v1/json", "3e40a821", "channelid", "creditcard");
$capture->setParameters(array('identification' => array('transactionid' => '123test', 'customerid' => '458'),
                        'payment' => array('amount' => '90', 'currency' => 'EUR', 'descriptor' => 'dfdfdfd')));
echo $capture->showJson();
var_dump($result = $capture->makeCall());
if($result instanceof SkrillPsp_Response_Success)
{
	
}
elseif ($result instanceof SkrillPsp_Response_ErrorLevel)
{
	 echo $result->getJsonResponse();
}
elseif ($result instanceof SkrillPsp_Response_Error)
{
	
}
