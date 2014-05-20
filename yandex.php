<?php
require_once 'lib/SkrillPSP.php';

try {
	$yandex = new SkrillPsp_Yandex();
	$yandex->setUri("https://api.nextgenp.com/merchants/zmcdptfj8kv9fwhj/testchannel_envoy/envoy");
	$yandex->setParameters(array('identification' => array('transactionid' => 'RRT45', 'customerid' => '5656'),
	                             'payment' => array('amount' => '1234', 'currency' => 'RUB', 'country' => 'RUS', 'descriptor' => 'Fkkgkkg'),
	                             'account' => array('money_source' => 'wallet'),
	                             'frontend' => array('language' => 'RU', 'responseurl' => 'http://merchant/response.php', 'successurl' => 'http://merchant/success.php',
	                                                 'errorurl' => 'https://merchant/error.php'),
	                             'customer' => array('name' => array('salutation' => 'Mr', 'firstname' => 'Rtjfgjg', 'lastname' => 'REfjjf'),
	                                                 'address' => array('street' => 'Rfjjfjf', 'zip' => 'EDkdk', 'city' => 'Tgjjg', 'state' => 'Rfhfhj', 'country' => 'RTrjjf'),
	                                                 'contact' => array('phone' => '345555', 'mobile' => '+456666', 'email' => 'ty@k.com', 'ip' => '127.0.0.10')),
	                             'merchant' => array('test' => 'kdkdkdkd')));
	$yandex->setFrontendLanguage('RT');
	echo $yandex->showJson();
	$result = $yandex->makeCall();
	var_dump($result); die();
} catch (Exception $e) {
	 echo $e->getMessage();
}