<?php
/**
 * Installation of library requires only one statement
 * 
 * require_once('PATH_TO_LIBRARY/lib/SkrillPSP.php'); 
 * 
 */
require_once('lib/SkrillPSP.php');
try { 
     // 1. Construct request object 
     //  1.1 you can provide token as constructor parameter
	     // $credit = new SkrillPsp_Credit("e385908642ae45e0bd12df98fa3fb892");
    //  1.2 if you don't provide token you must provide card details (cardholder, number, exp. date, cvv)
      $credit = new SkrillPsp_Credit("4f6aba874c214706b321941096718cf1");
           
     // 2. Set service end point via SkrillPSP::setMerchant() or SkrillPSP::setUri()
      $credit->setMerchantUrl("https://psp.dev.skrillws.net/v1/json", "3e40a821", "channelid", "creditcard");
    //  $credit->setUri("https://psp.dev.skrillws.net/v1/json/3e40a821/channelid/creditcard");
    
    // 3. Set required parameters through the setters or SkrillPsp::setParameters() method
    // You could use method chaining for the sake of brevity
   /*  $credit->setTransactionId("MN_8686")
            ->setCustomerId("39494")
            ->setAmount(45)
            ->setCurrency('GBP')
            ->setDescriptor("lkfklfkf")
            ->setTitle("Mr.")
            ->setFirstName('Ibrahim')
            ->setLastName('Musa')
            ->setCompany('Cicso')
            ->setStreet('Saddam Husein')
            ->setZip(3434343434)
            ->setCity('Bagdad')
            ->setState('dldldld')
            ->setCountry('Irak')
            ->setPhone('202020202')
            ->setMobile('+390303030303')
            ->setEmail('nbn313@yahoo.com')
            ->setIpAddress('127.1.0.0'); */
      
    // 3.1 This could be used instead of setters methods
     	$params = array('identification' => array('transactionid' => '6768', 'customerid' => ''),
        'payment' => array('amount' => '555', 'currency' => 'EUR', 'descriptor' => 'jggjgjg'),
           	'account' => array('cardholder' => 'Test', 'number' => '4000000000000051', 'expiry' => '12/2015', 'cvv' => '678'),
       		'customer' => array('name' => array('title' => 'Mrs', 'firstname' => 'Sarah', 'lastname' => 'Roly', 'company' => 'Cisco Systems'),
       				            'address' => array('street' => 'Test stree', 'zip' => 'jgjgjg', 'city' => 'Berlin', 'state' => 'BE', 'country' => 'DE'),
       				            'contact' => array('phone' => '+4545454545', 'mobile' => '+49888858585', 'email' => 'info@yahoo.com', 'ip' => '255.255.255.255'))
       );
       $credit->setParameters($params); 
      // $credit->setCVV('233');
    
    // 3.2 you might want to augment predefined Skrill request parameters
    // New parameters will be added {"params": { <<here>> }} member
   //    $credit->addParameters(array('country' => array('city' => 'Sofia')));

    // 4. If you want to check what your json request looks like and what you will send to server use showJson() method
    // This is mainly for debugging purposes
    echo $credit->showJson();
    
    // 5. Make a request/call to server and handle the response
    $result = $credit->makeCall();
    var_dump($result);
    // 6. Check if it is successfull
    if($result instanceof SkrillPsp_Response_Success) {
    	$iden = $result->getIdentification();
    	var_dump($iden);
    }
    if($result instanceof SkrillPsp_Response_Error) {
    	 echo $result->getAdvice();
    }
    if($result instanceof SkrillPsp_Response_ErrorLevel) {
    	 echo $result->getAdvice();
    	 echo $result->getErrorMessage();
    	 echo $result->getJsonResponse();
    }
}
catch(SkrillPsp_Exception $e) 
{
	echo $e->getTraceAsString();
	echo $e->getMessage();
}


?>