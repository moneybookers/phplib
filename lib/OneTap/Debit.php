<?php
/**
 * Class for OneTab debit requests
 * 
 * @package OneTab
 *
 *
 */
class OneTap_Debit extends SkrillPSP
{
	 /**
	  * Constructor
	  * 
	  * Loads json request source and and decodes it in php array and sets id member
	  * and referenceid parameter
	  *  
	  * @param string $token
	  * @return void
	  */
	 public function __construct($token)
	 {
	 	  $data = SkrillPsp_Json::getOneTapJson();
	 	  $this->json = $this->decode($data, true);
	 	  $this->json['id'] = $this->setId();
	 	  $this->json['params']['account']['token'] = $token;
	 }
	 
	 /**
	  * Override setParameters method in parent class
	  * because of different request parameters for Refund Request
	  * @see SkrillPSP::setParameters()
	  * @param array $params
	  * @return void
	  */
	 public function setParameters(array $params)
	 {
	 	foreach ($params as $key => $value)
	 	{
	 		switch ($key)
	 		{
	 			case "identification":
	 				foreach($value as $key => $value) {
	 					// validate section fields name
	 					if(!array_key_exists($key, $this->json['params']['identification'])) {
	 						throw new InvalidArgumentException("$key is not valid for identification section");
	 					}
	 
	 					$this->json['params']['identification'][$key] = $value;
	 				}
	 				break;
	 				
	 			case "payment":
	 				foreach($value as $key => $value) {
	 					// validate section fields name
	 					if(!array_key_exists($key, $this->json['params']['payment'])) {
	 						throw new InvalidArgumentException("$key is not valid for payment section");
	 					}
	 
	 					$this->validate($key, $value); // validator for field values
	 					$this->json['params']['payment'][$key] = $value;
	 				}
	 				break;

	 			case $this->account:
	 				foreach($value as $key => $value) {
	 					// validate section fields name
	 					if(!array_key_exists($key, $this->json['params'][$this->account])) {
	 						throw new InvalidArgumentException("$key is not valid for payment section");
	 					}
	 				
	 					$this->json['params'][$this->account][$key] = $value;
	 				}
	 				break;
	 			default:
	 				throw new OutOfBoundsException("You should set predefined parameter group!");
	 		}
	 	}
	 }
	 
	 /**
	  * Checks json-rpc request object for required parameters and makes POST request
	  * @throws SkrillPsp_Exception
	  * @return SkrillPsp_Response_Success|SkrillPsp_Response_Error|SkrillPsp_Response_ErrorLevel
	  */
	 public function makeCall()
	 {
	 	if(is_null($this->getMerchant())) {
	 		throw new SkrillPsp_Exception("You should set endpoint, merchantId, channelId and payment method");
	 	}
	 
	 	return SkrillPsp_Http::post($this->url, $this->encode($this->json));
	 }
	 
	 
} 