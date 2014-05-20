<?php
require_once 'lib/SkrillPSP.php';

try {
	$params = array(
			"amount" => 1000,
			"merchant_id" => "3e40a821",
			"customer" => array(
					"firstname" => "John",
					"country" => "DE",
					"email" => "wpf@skrill.com",
					"ip" => ($_SERVER['REMOTE_ADDR'])
			),
			"method" => "debit",
			"currency" => "USD",
			"theme"=>"skeuo",
			"descriptor" => "wpf test",
			"transaction_id" => "FOO",
			"channel_id" => "channelid",
			"success_url" => "http://www.skrillbox.com/niliev/merchant/success_url.php",
			"response_url" => "http://www.skrillbox.com/niliev/merchant/wpf_response.php",
			"error_url" => "http://www.reactiongifs.com/wp-content/uploads/2013/07/NO.gif"
	);
	$obj = new WPF_Call();
	$obj->setUri("https://wpf.dev.skrillws.net/3e40a821/payments/new?payload");
	$obj->setParameters("B[zcj2AGQmL@3k", $params);
	// echo $obj->getResult();
	
	echo "<br><br><b> the url is"."<a href=". $obj->getResult() ."> here </b></a>";
	//echo "<br><br><b> the url is"."<a href=https://wpf.dev.skrillws.net/3e40a821/payments/new?payload=".crypt_data("B[zcj2AGQmL@3k", json_encode($array))."> here </b></a>";
}
catch (Exception $e) {
	
}