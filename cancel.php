<?php
require_once 'lib/SkrillPSP.php';

try {
	$cancel = new SkrillPsp_Cancel("860a2692d88b4c6dbe2f1d0151519c51");
	$cancel->setMerchantUrl("https://psp.dev.skrillws.net/v1/json", "3e40a821", "channelid", "creditcard");
    $cancel->setParameters(array('identification' => array('transactionid' => '1234', 'referenceid' => '8204a78c5dff41d48ff1770889005946'),
                                 'payment' => array('amount' => '56', 'currency' => 'USD', 'descriptor' => 'jhjhjhj, kgfkfkf.'),
                                 ));
	echo $cancel->showJson();
	var_dump($cancel->makeCall());
	$result = $cancel->makeCall();
	if($result->isSuccess()) {
		echo $result->code . "<br />";
		echo $result->level . "<br />";
		echo $result->method . '<br />';
		echo $result->type;
		var_dump($result->getIdentification());
		var_dump($result->getTokenFromAccount());
	}
} catch (SkrillPsp_Exception $e) {
	echo $e->getMessage();
}
