<?php
// include library
require_once '../lib/SkrillPSP.php';

// the flow is the same for other types of request

try {
	// Create request object with referenceID for refund/capture request
	$preauth = new SkrillPsp_Preauthorization("c21a0ef567a14d7bad56582099f9f7c8");
	
	// Set service end point via SkrillPSP::setMerchant() or SkrillPSP::setUri()
	$preauth->setMerchantUrl("https://psp.dev.skrillws.net/v1/json", "3e40a821", "channelid_3d", "creditcard");
	// $preauth->setUri("https://psp.dev.skrillws.net/v1/json/3e40a821/channelid_3d/creditcard");
	
	// Set required parameters through the setters or SkrillPsp::setParameters() method
	// You can use setParameters method and set all parameters at once instead of each one of set.XXX methods obe after another
	// setParameters method can save you typing in return for clearness
/*	$preauth->setTransactionId("Ckdkd12")
		   ->setCustomerId("39393993")
		   ->setAmount("457")
		   ->setCurrency("EUR")
		   ->setDescriptor("sdsd")
	       ->setCardholder("Peter Hansel")
	       ->setCardNumber("5200000000000056")
	       ->setExpiryDate("12/2015")
	       ->setCVV(122)
	       ->setTitle("Mr.")
	       ->setFirstName('Ibrahim')
	       ->setLastName('Musa')
	       ->setCompany('Cicso')
	       ->setStreet('Saddam Husein')
		   ->setZip('1001')
	       ->setCity('Bagd')
	       ->setState('dldldld')
	       ->setCountry('US')
	       ->setPhone('202020202')
	       ->setMobile('+390303030303')
	       ->setEmail('nbn313@yahoo.com')
	       ->setIpAddress('127.1.0.0'); */
	
	    $params = array('identification' => array('transactionid' => 'CRM_F56A', 'customerid' => '122456'),
	                    'payment'  => array('amount' => '128', 'currency' => 'USD', 'descriptor' => 'grgrg'),
			            'account'  => array('cardholder' => 'Joe Dofof', 'number' => '4000000000000051', 'expiry' => '01/2015', 'cvv' => '123'),
			            'customer' => array('name' => array('title' => 'Mrs', 'firstname' => 'Sarah', 'lastname' => 'Roly', 'company' => 'Cisco Systems'),
					                  'address' => array('street' => 'Test stree', 'zip' => '1001', 'city' => 'Berlin', 'state' => 'BE', 'country' => 'DE'),
					                  'contact' => array('phone' => '+4545454545', 'mobile' => '', 'email' => 'info@test', 'ip' => '122.20.20')),
			             'merchant' => array('key' => 'value4545')
	    );
	 
	$preauth->setParameters($params); 
	// addParameters allows you to augment the predefined request parameters
	$preauth->addParameters(array('frontend' => array('responseurl' => 'http://resp.php', 'successurl' => 'http://success.php', 'errorurl' => 'http://error.php')));
	
	
	// You can check builded request through showJson method before or after make call
	echo $preauth->showJson();

	// send request and save the response
	$result = $preauth->makeCall();	
	
	// check response object for success or error accordingly
	if($result->isSuccess()) {
		// work with result method and properties
		$identity = $result->getIdentification();
		$payment = $result->getPayment();
		echo $result->type;
		echo $result->message;
	}
	else {
		// work with error data
		$data = $result->getErrorData();
		$errorData = $result->getError();
	}
	
} catch (SkrillPsp_Exception $e) {
	 echo $e->getMessage();
}