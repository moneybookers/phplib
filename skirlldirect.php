<?php
require_once 'lib/SkrillPSP.php';

try {
	$skrill = new SkrillPsp_SkrillDirect();
	$skrill->setUri("https://psp.dev.skrillws.net/v1/json/3e40a821/channelid_skrilldirect/skrilldirect");
	
    $skrill->setParameters(array('payment' => array('amount' => '112', 'currency' => 'EUR', 'descriptor' => 'hjhjhjh', 'recipient' => ''),
                                  'account' => array('holder' => 'Tgjgjgjg', 'accountnumber' => '797979', 'routingnumber' => '6767676'),
    		                      'frontend' => array('responseurl' => 'http://test/merchant.php', 'successurl' => 'http://test/success.php', 'errorurl' => 'http://merhc/error.php'),
                                  'customer' => array('name' => array('firstname' => 'Tgogog', 'lastname' => 'Tgkgkg'),
                                                      'address' => array('street' => 'Fkfkfkfkf', 'zip' => '34343', 'city' => 'Berlin', 'country' => 'DE'),
                                                      'contact' => array('email' => 'in@in.de', 'ip' => '124.20.2.2'))));
    echo $skrill->showJson();
	$result = $skrill->makeCall();
	if($result->isSuccess()) {
        // success
	}
	elseif ($result->isError()) {
		// error
	}
	elseif ($result->isErrorLevel()) {
		// error level
	}
	
} catch (SkrillPsp_Exception $e) {
	echo $e->getMessage();
}