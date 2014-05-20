<?php
/**
 * Class for Lobanet alternative payment requests
 * @package SkrillPsp
 *
 */
class SkrillPsp_Lobanet extends SkrillPSPAlternativePayment
{
	  private $method = 'preauthorization';
	  
	  /**
	   * Constructor
	   *
	   * Loads json request source and and decodes it in php array and sets id and method
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
	   * @param string $country
	   * @return object SkrillPsp_Lobanet
	   */
	  public function setPaymentCountry($country)
	  {
	  	   $this->json['params']['payment']['country'] = $country; 
	  	   
	  	   return $this;
	  }
	  
	  /**
	   * Overrides method from parent class that should not be used in this class
	   * @throws OutOfBoundsException
	   */
	  public function setCustomerFirstName()
	  {
	  	  throw new OutOfBoundsException("First name parameter is not availbale for Lobanet");
	  }
	  
	  /**
	   * Overrides method from parent class that should not be used in this class
	   * @throws OutOfBoundsException
	   */	  
	  public function setCustomerLastName()
	  {
	  	   throw new OutOfBoundsException("Last name parameter is not availbale for Lobanet");
	  }
	  
	  /**
	   * Overrides method from parent class that should not be used in this class
	   * @throws OutOfBoundsException
	   */	  
	  public function setCustomerSalutation()
	  {
	  	   throw new OutOfBoundsException("Salutation parameter is not availbale for Lobanet");
	  }
	  
	  /**
	   * Overrides method from parent class that should not be used in this class
	   * @throws OutOfBoundsException
	   */
	  public function setCustomerCountry()
	  {
	  	   throw new OutOfBoundsException("Country parameter is not availbale for Lobanet");
	  }

	  /**
	   * Overrides method from parent class that should not be used in this class
	   * @throws OutOfBoundsException
	   */
	  public function setCustomerStreet()
	  {
	  	  throw new OutOfBoundsException("Customer street parameter is not availbale for Lobanet");
	  }

	  /**
	   * Overrides method from parent class that should not be used in this class
	   * @throws OutOfBoundsException
	   */
	  public function setCustomerZip()
	  {
	  	    throw new OutOfBoundsException("Customer zip parameter is not availbale for Lobanet");
	  }

	  /**
	   * Overrides method from parent class that should not be used in this class
	   * @throws OutOfBoundsException
	   */
	  public function setCustomerCity()
	  {
	  	    throw new OutOfBoundsException("Customer city parameter is not availbale for Lobanet");
	  }

	  /**
	   * Overrides method from parent class that should not be used in this class
	   * @throws OutOfBoundsException
	   */
	  public function setCustomerState()
	  {
	  		throw new OutOfBoundsException("Customer state parameter is not availbale for Lobanet");
	  }

	  /**
	   * Overrides method from parent class that should not be used in this class
	   * @throws OutOfBoundsException
	   */
	  public function setCustomerMobile()
	  {
	  		throw new OutOfBoundsException("Customer mobile parameter is not availbale for Lobanet");
	  }

	  /**
	   * Overrides method from parent class that should not be used in this class
	   * @throws OutOfBoundsException
	   */
	  public function setCustomerPhone()
	  {
	  		throw new OutOfBoundsException("Customer phone parameter is not availbale for Lobanet");
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