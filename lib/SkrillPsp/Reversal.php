<?php
/**
 * Class for reversal request
 * @package SkrillPsp
 *
 */
class SkrillPsp_Reversal extends SkrillPSP
{
	 private $referenceId;
	
	 /**
	  * Constructor
	  * 
	  * Loads json request source and and decodes it in php array and sets id member
	  * and referenceid parameter 
	  * @param string $referenceId optional
	  * @return void
	  */
	 public function __construct($referenceId = null)
	 {
	 	  $data = SkrillPsp_Json::getReversalJson();
	 	  $this->json = $this->decode($data, true);
	 	  
	 	  $this->json['id'] = $this->setId();
	 	  $this->referenceId = $referenceId;
	 	  
	 	  if(!empty($this->referenceId)) {
	 	  	$this->json['params']['identification']['referenceid'] = $this->referenceId;
	 	  }
	 }
	 
	 
	 /**
	  * Override setParameters method in parent class
	  * because of different request parameters for Reversal Request
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
	 					// if referenceId parameter is not set in the constructor
	 					if('' === $this->json['params']['identification']['referenceid'])
	 						$this->json['params']['identification'][$key] = $value; 
	 				}
	 				break;
	 			default:
	 				throw new OutOfBoundsException("You should set predefined parameter group!");
	 		}
	 	 }	 	  
	 }
	 
	 /**
	  * Overrides method from parent class that should not be used in this class
	  * @throws OutOfBoundsException
	  */
	 public function setAmount()
	 {
	 	throw new OutOfBoundsException("Reversal request does not support amount parameter");
	 }
	 
	 /**
	  * Overrides method from parent class that should not be used in this class
	  * @throws OutOfBoundsException
	  */
	 public function setCurrency()
	 {
	 	throw new OutOfBoundsException("Reversal request does not support currency parameter");
	 }
	  
	 /**
	  * Overrides method from parent class that should not be used in this class
	  * @throws OutOfBoundsException
	  */
	 public function setDescriptor()
	 {
	 	throw new OutOfBoundsException("Reversal request does not support descriptor parameter");
	 }
	 
	 /**
	  * Checks json-rpc request object for required parameters and makes POST request
	  * @throws SkrillPsp_Exception
	  * @return object SkrillPsp_Response_Success|SkrillPsp_Response_Error|SkrillPsp_Response_ErrorLevel
	  */	 
	 public function makeCall()
	 {
	 	  if(is_null($this->getMerchant())) {
	 		   throw new SkrillPsp_Exception("You should set endpoint, merchantId, channelId and payment method");
	 	  }
	 	  
	 	  return SkrillPsp_Http::post($this->url, $this->encode($this->json));
	 }
}