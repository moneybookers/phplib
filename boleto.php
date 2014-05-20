<?php
require_once 'lib/SkrillPSP.php';

try {
	 $obj = new SkrillPsp_BoletoBancario();
	 //  WebMoney and Boleto end point
	 $obj->setUri("https://api.nextgenp.com/merchants/zmcdptfj8kv9fwhj/testchannel_envoy/envoy");
/*	 $obj->setFrontendResponseUrl("http://www.google/response.php")
	     ->setAccountFiscalId("38383838383")
	     ->setFrontendLanguage("FR")
	     ->setFrontendSuccessUrl("http://www.google/success.php")
	     ->setAmount("456")->setCurrency('EUR')->setDescriptor("fjfjfj")
	     ->setFrontendErrorUrl("http://www.google/error.php")
	     ->setCustomerSalutation("Mrs")->setCustomerFirstName("Ivan")
	     ->setCustomerLastName("Ivanov")
	     ->setCustomerStreet("Rhghgh dhd 34")
	     ->setCustomerZip("RTY45")
	     ->setCustomerCity("Riga")
	     ->setCustomerState("Georgia")
	     ->setCustomerCountry("USA")
	     ->setCustomerEmail("test@google.com")
	     ->setCustomerMobile("45667676")
	     ->setCustomerPhone("4545454")
	     ->setCustomerIp("121.18.19.20");  */
	 
	 $obj->setParameters(array('identification' => array('transactionid' => '123', 'customerid' => '123'),
	                           'payment' => array('amount' => '1234', 'currency' => 'BRL', 'country' => 'TY', 'descriptor' => 'descriptor'),
	                           'account' => array('fiscal_id' => '28001238938'),
	                           'frontend' => array('language' => 'EN', 'responseurl' => 'http://test/response.php', 'successurl' => 'http://test/success.php', 'errorurl' => 'http://test/error.php'),
	                           'customer' => array('name' => array('salutation' => 'Mr', 'firstname' => 'John', 'lastname' => 'Smith'),
	                                               'address' => array('street' => 'RUA Dos Boqusa', 'zip' => '11525-232', 'city' => 'Rio', 'state' => 'RJ', 'country' => 'BR'),
	                                               'contact' => array('email' => 'merchant@merchant', 'mobile' => '+45 474774', 'phone' => '+49 99 39', 'ip' => '127.0.0.1')), 
	                           'merchant' => array('ke' => 'Sofia', 'key2' => 'Plovdiv')));  
	 echo $obj->showJson();
     $result = $obj->makeCall();
	 var_dump($result); die();
}
catch (SkrillPsp_Exception $e)
{
	echo $e->getCode();
    echo $e->getMessage();	 
}