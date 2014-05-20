<?php
/**
 * Class for QIWI Cancel Invoice requests
 * @package SkirllPsp
 *
 */
class SkrillPsp_QIWICancelInvoice extends SkrillPSP
{
	 private $method = 'cancelInvoice';
	 
	 /**
	  * Constructor
	  *
	  * Loads json request source and decodes it in php array and sets id
	  * and method members 
	  * @return void
	  */
	 public function __construct()
	 {
	 	  $data = SkrillPsp_Json::getQIWIJson();
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
	 		 		
	 			default:
	 				throw new OutOfBoundsException("You should set predefined parameter group! Parameter not supported for this type of request");
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