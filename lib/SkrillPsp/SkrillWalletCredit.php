<?php
/**
 * Class for Skrill Wallet Credit requests
 * @package SkrillPsp
 *
 */
class SkrillPsp_SkrillWalletCredit extends SkrillPSP
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
	  			case $this->identification:   
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
	   * Set payment subject parameter
	   * 
	   * @param string $subject
	   * @return object SkrillPsp_SkrillWalletCredit
	   */
	  public function setPaymentSubject($subject)
	  {
	  	    $this->json['params']['payment']['subject'] = $subject;
	  	    
	  	    return $this;
	  }
	  
	  /**
	   * Set payment note parameter
	   * 
	   * @param string $note
	   * @return object SkrillPsp_SkrillWalletCredit
	   */
	  public function setPaymentNote($note)
	  {
	  	   $this->json['params']['payment']['note'] = $note;
	  	   
	  	   return $this;
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
	   * Set customer firstname parameter
	   *
	   * @param string $firstname
	   * @return object SkrillPsp_SkrillWalletCredit
	   */
	  public function setCustomerFirstName($firstname)
	  {
	  		$this->json['params']['customer']['name']['firstname'] = $firstname;
	  	 
	  		return $this;
	  }
	  
	  /**
	   * Set customer lastname parameter
	   *
	   * @param string $lastname
	   * @return object SkrillPsp_SkrillWalletCredit
	   */
	  public function setCustomerLastName($lastname)
	  {
	  		$this->json['params']['customer']['name']['lastname'] = $lastname;
	  
	  		return $this;
	  }
	  
	  /**
	   * Set customer email parameter
	   *
	   * @param string $email
	   * @return object SkrillPsp_SkrillWalletCredit
	   */
	  public function setCustomerEmail($email)
	  {
	  		if($this->isValidEmail($email)) {
	  			$this->json['params']['customer']['contact']['email'] = $email;
	  		}
	  		
	  		return $this;
	  }
	  
	  /**
	   * Set customer ip parameter
	   *
	   * @param string $ip
	   * @return object SkrillPsp_SkrillWalletCredit
	   */
	  public function setCustomerIp($ip)
	  {
	  		if($this->isValidIp($ip)) {
	  			$this->json['params']['customer']['contact']['ip'] = $ip;
	  		}
	  		
	  		return $this;
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