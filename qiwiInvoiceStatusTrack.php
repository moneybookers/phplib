<?php
require_once 'lib/SkrillPSP.php';

try {
    $obj = new SkrillPsp_QIWIInvoiceStatusTrack();
    $obj->setUri("https://api.nextgenp.com/merchants/zmcdptfj8kv9fwhj/testchannel_qiwi/qiwi");
    echo $obj->showJson();
    $result = $obj->makeCall();
    var_dump($result);
}
catch (Exception $e) {
	echo $e->getCode();
	echo $e->getMessage();
}