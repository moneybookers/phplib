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
			"method" => "DB",
			"currency" => "USD",
			"theme"=>"skeuo",
			"descriptor" => "wpf test",
			"transaction_id" => "FOO",
			"channel_id" => "channelid_3d",
			"success_url" => "http://www.reactiongifs.com/wp-content/uploads/2013/07/oh-yes.gif",
			"response_url" => "http://www.skrillbox.com/niliev/merchant/wpf_response.php",
			"error_url" => "http://www.reactiongifs.com/wp-content/uploads/2013/07/NO.gif"
	);
	
	// Create WPF Call object
	$obj = new WPF_Call();
	
	// Set service endpoint
	$obj->setUri("https://wpf.dev.skrillws.net/3e40a821/payments/new?payload");
	
	// Set request parameters
	$obj->setParameters("B[zcj2AGQmL@3k", $params);
	
	// Get the result - wpf endpoint with provided parameters appended to it
	echo $obj->getResult();

}
catch (Exception $e) {
	echo $e->getMessage();
}
