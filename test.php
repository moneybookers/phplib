<?php
var_dump(json_decode('{"result":{"identification":{"transactionid":"TY565661","uniqueid":"1b37b1cb3f69463d82da3908835f92e7","shortid":"0094.1327.6266","customerid":"5677"},"method":"paysafecard","type":"preauthorization","level":0,"code":0,"message":"new","processing":{"timestamp":"2013-12-03T16:00:12+00:00","redirecturl":"https://customer.test.at.paysafecard.com/psccustomer/GetCustomerPanelServlet?mid=1000004553&mtid=009413276266&amount=56.56&currency=EUR"}},"id":"3107051301","jsonrpc":"2.0"}',false));
$url = 'https://www.moneybookers.com/app/payment.pl';
$url = 'https://www.moneybookers.com/app/test_payment.pl';
//$request = array('pay_to_email' => 'nbn313@yahoo.com', 'amount' => '10.99', 'currency' => 'EUR', 'language' => 'EN', 'prepare_only' => 1);
$request = array('action' => 'prepare', 'email' => 'mb654@abv.bg', 'passwrod' => 'gullgtj961', 'amount' => '20', 'currency' => 'EUR', 'bnf_email' => 'mb123@abv.bg',
                 'subject' => 'Test subject', 'note' => 'sdkdkkfkf', 'frn_trn_id' => '111');
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false); 
curl_setopt($curl, CURLOPT_POSTFIELDS, $request);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
//$response = curl_exec($curl);
//echo $response;
//echo "<a href='https://www.moneybookers.com/app/payment.pl?sid=34ef85d949377706b6a5674ac5dbadc3'>Test</a>";