<?php
require_once('lib/SkrillPSP.php');


try {
	$obj = new SkrillPsp_QIWICreateInvoice();
	$obj->setUri("https://api.nextgenp.com/merchants/zmcdptfj8kv9fwhj/testchannel_qiwi/qiwi");
	$obj->setParameters(array('identification' => array('transactionid' => '232323', 'qiwiuser' => 'tel:+6767676'),
	                           'payment' => array('amount' => '456', 'currency' => 'EUR', 'descriptor' => 'comment', 'lifetime' => '2'),
	                           'frontend' => array('responseurl' => 'http://pancho.skrillbox.com/bernhard/response.php',
	                                               'successurl' => 'http://pancho.skrillbox.com/bernhard/response.json.php',
	                                               'errorurl' => 'http://pancho.skrillbox.com/bernhard/response.json.php'),
	                           'customer' => array('name' => array('salutation' => 'Mr', 'title' => 'Dr.', 'given' => 'Ykykyyk', 'family' => 'Doe', 'company' => 'Skrill'),
	                                                'address' => array('street' => 'Tkgkgkg', 'zip' => '45555', 'city' => 'Sofia', 'state' => 'RT', 'country' => 'RT'),
	                                                'contact' => array('phone' => '+46466464', 'mobile' => '4646464', 'email' => 'test@dir.bf'))));
    echo $obj->showJson();
    $result = $obj->makeCall();
    var_dump($result);
} 
catch(SkrillPsp_Exception $e)
{
   echo $e->getCode();
   echo $e->getMessage();	
}