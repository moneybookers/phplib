<?php
require_once 'lib/SkrillPSP.php';

try {
	// Create OneTab Register object
	$one = new OneTap_Register();

	// Set service endpoint
	$one->setUri('https://psp.sandbox.dev.skrillws.net/v1/json/3e40a821/channelid/skrillwallet');

	// Set request parameters
	$one->setParameters(array('identification' => array('transactionid' => 'RT5', 'customerid' => 'TYy6868'),
			'payment' => array('amount' => '1984',
					'currency' => 'eur',
					'descriptor' => 'descriptor line',
					'payment_methods' => array('SFT', 'LSR'),
			        'ondemand_max_amount' => '56',
					'ondemand_note' => 'ddkdkdk'
			        ),
			'frontend' => array('amount_details' => array(array("86", "amount1 desc1"), array("678", "amount2 desc")),
					'responseurl' => 'https://skrillbox.com/niliev/merchant/wpf_response.php',
					'successurl' => array('url' => 'https://skrillbox.com/niliev/merchant/success_url.php',
							'text' => 'Return to sample merchant',
							'target' => '4'),
					'errorurl' => array('url' => 'http://pancho.skrillbox.com/bernhard/response.php',
							'target' => '4'),
					'new_window_redirect' => "0",
					'language' => 'EN',
					'hide_login' => '1',
					'confirmation_note' => 'Thanks for shopping with us',
					'logo_url' => 'https://nelly.com/img/nellylogotyp_com_smal.png',
					'rid' => '123445',
					'ext_ref_id' => 'AffiliateName',
					'detail_descriptions' => array(array("detail description", "detail text"), array("detail description", "detail text"))),
                        'account' => array('username' => 'ivan.govedarov@skrill.com', 'password'=>'3e9271f2213ccfba9149fbeeb2727d0c'),
			'customer' => array('name' => array("salutation" => "Mr",
					"title" => "Mr",
					"firstname" => "John",
					"lastname" => "Doe",
					"company" => "Skrill"),
					'address' => array("street" => "Karl-Lieb",
							"zip" => "10117",
							"city" => "Berlin",
							"state" => "BE",
							"country" => "UK"),
					'contact' => array('phone' => '+49302341423',
							'mobile' => '+49 172 931 44 01',
							'email' => 'mb654@abv.bg',
							'ip' => '127.0.0.1')),
		//	'merchant' => array('product' => 'Nokia', 'model' => 'X35H', 'color' => 'red', 'weight' => '250g', 'type' => 'tablet')
	             ));

	// Allows you to view request in raw json format
	echo $one->showJson();

	// Make OneTab Register request
	$result = $one->makeCall();
    var_dump($result);
	// Handle the response
	if($result->isSuccess()) {
		echo $result->getRedirectUrl();
		$url = $result->getRedirectUrl();
		$time = $result->getTimeStamp();
	}
	elseif ($result->isError()) {
		// error
	}
	elseif ($result->isErrorLevel()) {
		// error level
	}

}
catch (Exception $e) {
	echo $e->getMessage();
	echo $e->getTraceAsString();
}