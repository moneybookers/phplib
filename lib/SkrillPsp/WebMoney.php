<?php
/**
 * Class for WebMoney alternative payment requests
 * @package SkrillPsp
 *
 */
class SkrillPsp_WebMoney extends SkrillPSPAlternativePayment
{
	 private $method = 'preauthorization';

	 /**
	  * Constructor
	  *
	  * Decodes json source in php array and sets id and method members of json request
	  * @return void
	  */
	 public function __construct()
	 {
	 	  $data = SkrillPsp_Json::getAlternativeWithoutAccountJson();
	 	  $this->json = $this->decode($data, true);
	 	
	 	  $this->json['id'] = $this->setId();
	 	  $this->json['method'] = $this->method;
 	 }
	 
 	 /**
 	  * Override setParameters method in parent class
 	  * because of different request parameters for BoletoBancario Request
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
	 			case $this->identification:   // section
	 				foreach($value as $key => $value) {
	 					// validate section fields name
	 					if(!array_key_exists($key, $this->json['params']['identification'])) {
	 						throw new InvalidArgumentException("$key is not valid for identification section.");
	 					}
	 					$this->json['params']['identification'][$key] = $value;
	 				}
	 				break;
	 	
	 			case $this->payment:
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
	 				foreach ($value as $key => $value) {
	 					// validate section fields name
	 					if(!array_key_exists($key, $this->json['params']['account'])) {
	 						throw new InvalidArgumentException("$key is not valid for account section");
	 					}
	 					$this->validate($key, $value); // validator for field values
	 	
	 					$this->json['params']['account'][$key] = $value;
	 				}
	 	
	 				break;
	 	
	 			case $this->frontend:
	 				foreach ($value as $key => $value) {
	 					// validate section field name
	 					if(!array_key_exists($key, $this->json['params']['frontend'])) {
	 						throw new InvalidArgumentException("$key is not valid for frontend section");
	 					}
	 					$this->validate($key, $value);
	 	
	 					$this->json['params']['frontend'][$key] = $value;
	 				}
	 	
	 				break;
	 	
	 			case $this->customer:
	 				foreach ($value as $key => $value) {
	 					// validate section fields name
	 					if(!array_key_exists($key, $this->json['params']['customer'])) {
	 						throw new InvalidArgumentException("$key is not valid for customer section");
	 					}
	 					foreach($value as $k => $v) {
	 						// validate sub-section fields name
	 						if(!array_key_exists($k, $this->json['params']['customer'][$key])) {
	 							throw new InvalidArgumentException("$k is not valid for $key sub-section of customer section");
	 						}
	 						$this->json['params'][$this->customer][$key][$k] = $v;
	 					}
	 				}
	 				break;
	 	
	 			case $this->merchant:
	 				foreach($value as $key => $value) {
	 					$this->json['params'][$this->merchant][$key] = $value;
	 				}
	 				break;
	 	
	 			default:
	 				throw new OutOfBoundsException("You should set predefined parameter group!");
	 		}
	 	}	 	   
	 }
	 
	 /**
	  * Set payment country parameter
	  * 
	  * @param string $country
	  * @return object SkrillPsp_WebMoney
	  */
	 public function setPaymentCountry($country)
	 {
	 	  $this->json['params'][$this->payment]['country'] = $country;
	 	  
	 	  return $this;
	 }
	 
	 /**
	  * Set frontend cancelurl parameter
	  * 
	  * @param string $url
	  * @return object SkrillPsp_WebMoney
	  */
	 public function setCancelUrl($url)
	 {
	 	 $this->json['params'][$this->frontend]['cancelurl'] = $url;

	 	 return $this;
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