<?php
/**
 * Class for check email requests
 * @package SkrillPsp
 *
 */
class SkrillPsp_CheckEmail extends SkrillPSP
{
	 private $email;
	 
	 /**
	  * Constructor
	  * 
	  * Loads json request source and and decodes it in php array and sets id member and 
	  * email parameter
	  * @param string $email
	  * @throws InvalidArgumentException
	  * @return void
	  */
	 public function __construct($email)
	 {
	 
           $this->email = $email;
	 	   $data = SkrillPsp_Json::getEmailCheckJson();
	 	   $this->json = $this->decode($data, true);
	 	   $this->json['id'] = $this->setId();
	 	   
	 	   if(!empty($this->email)) {
	 	   		$this->json['id'] = $this->setId();
	 	   		$this->json['params']['account']['email'] = $this->email;	   	   
	 	   }
	 	   else {
	 	   	   throw new InvalidArgumentException("Please provide email");
	 	   }
	 	   
	 }
	 
	 /**
	  * Overrides method from parent class that should not be used in this class
	  * @throws OutOfBoundsException
	  */
	 public function setAmount()
	 {
	 	throw new OutOfBoundsException("Register request does not support amount parameter");
	 }
	 
	 /**
	  * Overrides method from parent class that should not be used in this class
	  * @throws OutOfBoundsException
	  */
	 public function setCurrency()
	 {
	 	throw new OutOfBoundsException("Register request does not support currency parameter");
	 }
	  
	 /**
	  * Overrides method from parent class that should not be used in this class
	  * @throws OutOfBoundsException
	  */
	 public function setDescriptor()
	 {
	 	throw new OutOfBoundsException("Register request does not support descriptor parameter");
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
