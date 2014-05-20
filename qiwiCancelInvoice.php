<?php
require_once 'lib/SkrillPSP.php';

try {
	$cancel = new SkrillPsp_QIWIRefund("696886868686");
	$cancel->setUri("https://api.nextgenp.com/merchants/zmcdptfj8kv9fwhj/testchannel_qiwi/qiwi");
   $cancel->setParameters(array('identification' => array('referenceid' => '456', 'transactionid' => 'RTY'),
                                'payment' => array('amount' => '234', 'currency' => 'RUB', 'descriptor' => 'decriptor')));
	echo $cancel->showJson();
	$result = $cancel->makeCall();
	var_dump($result);
}
catch (SkrillPsp_Exception $e) {
	 echo $e->getMessage();
	 echo "<br />";
	 echo $e->getCode();
}