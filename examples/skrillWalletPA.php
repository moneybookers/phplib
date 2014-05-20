<?php
require_once 'lib/SkrillPSP.php';

try {
		// Create SkrillWallet PA request object	
		$obj = new SkrillPsp_SkrillWalletPreauthorization();

		// Set service endpoint
		$obj->setUri("https://psp.dev.skrillws.net/v1/json/3e40a821/channelid_skrillwallet/skrillwallet");

		//Set request parameters
		$obj->setParameters(array('identification' => array('transactionid' => 'RT126', 'customerid' => 'TYY66'),
		                  'frontend' => array('responseurl' => 'http://www.skrillbox.com/niliev/merchant/wpf_response.php',
		                  		              'successurl' => 'http://merchant.com/success.php',
                                              'successurl_url_text' => 'Return to sample merchant',
                                              'errorurl' => 'http://merchant.com/error.php', 
		                  		              'language' => 'DE', 
		                  		              'errorurl_url_target' => 'ghghgh',
		                                      'new_window_redirect' => '1', 
		                  		              'hide_login' => '1',  // thows method not supported
		                  		              'ext_ref_id' => '', // opt
		                                      'confirmation_note' => 'fdhfhhf fhfhfhfh',  // optional
		                                      'logo_url' => 'http://merchant.com/logo.gif', // opt
		                                      'rid' => '2323', 'detail_description1' => 'test description', 'detail_text1' => 'test desciption',
		                                       ),
		                   'payment' => array('amount' => '500', 'currency' => 'EUR', 'descriptor' => ''), 
                           'customer' => array('name' => array('firstname' => 'nick', 'lastname' => 'nick'),
                           		               'address' => array('street' => 'Tets strr', 'zip' => '45454', 'city' => 'Berlin', 'country' => 'DE'),
                           		               'contact' => array('email' => 'mb654@abv.bg', 'ip' => '124.0.0.12')
                                         )));

        // Allows you to view request in raw json format
		echo $obj->showJson();
		
		// Make SkrillWallet PA request
        $result = $obj->makeCall();

        // Handle the response
        if($result->isSuccess()) {
        	// success
        }
        elseif ($result->isError()) {
        	// error
        }
        elseif ($result->isErrorLevel()) {
        	// error level
        }

}
catch (Exception $e)
{
	  echo $e->getMessage();
	  echo $e->getTraceAsString();
}
