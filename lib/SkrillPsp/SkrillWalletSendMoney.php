<?php
/**
 * Class for Skrill Wallet Send Money requests
 * @package SkrillPsp
 *
 */
class SkrillPsp_SkrillWalletSendMoney extends SkrillPSPAlternativePayment
{
	  public function __construct()
	  {
	  	   $data = SkrillPsp_Json::getSkrillWalletSendMoneyJson();
	  	   $this->json = $this->decode($data, true);  	   
	  	   $this->json['id'] = $this->setId();
	  }
	  
	  /**
	   * Override setParameters method in parent class
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
  				foreach($value as $key => $value) {
  					// validate section fields name
  					if(!array_key_exists($key, $this->json['params']['account'])) {
  
  						throw new InvalidArgumentException("$key is not valid for account section.");
  					}
  					$this->json['params']['account'][$key] = $value;
  				}
  				break;
                                
                                case $this->frontend:
					foreach ($value as $key => $value) {
						// validate section field name
						if(!array_key_exists($key, $this->json['params']['frontend'])) {
							throw new InvalidArgumentException("$key is not valid for frontend section");
						}
	
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
	  
	  			default:
	  				throw new OutOfBoundsException("You should set predefined parameter group!");
	  		}
	  	}
	  }

	  /**
	   * Checks json-rpc request object for required parameters and makes POST request
	   *
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