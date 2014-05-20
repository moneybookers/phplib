<?php
/**
 * Class for OneTab register requests
 * 
 * @package OneTab
 * 
 *
 */
class OneTap_Register extends SkrillPSPAlternativePayment
{
	/**
	 * Constructor
	 *
	 * Loads json request source and and decodes it in php array and sets id member
	 * 
	 *
	 * @return void
	 */	   
	  public function __construct()
	  {
	  	   $data = SkrillPsp_Json::getOneTapRegisterJson();
	  	   $this->json = $this->decode($data, true);
	  	   
	  	   if(empty($this->json['params']['merchant'])) {
	  	   		unset($this->json['params']['merchant']);
	  	   }
	  	   
	  	   $this->json['id'] = $this->setId();
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
?>