<?php
/**
 * Class for iDEAL alternative payment requests
 * @package SkrillPsp
 *
 */
class SkrillPsp_iDEAL extends SkrillPSPAlternativePayment
{
	  // Unique iDEAL methods
      private $method = 'preauthorization';
      private $directoryRequest = 'directory';
      // Parameter that is unique for iDEAL
      private $issuerid = '';

      
      /**
       * Constructor
       *
       * Loads json request source and and decodes it in php array and sets id,
       * method, issuerid and other modifications for correct request
       *
       * @return void
       */
	  public function __construct()
	  {
	  	    $data = SkrillPsp_Json::getAlternativeWithAccountJson();
	  		$this->json = $this->decode($data, true);
	  		
	  		$this->json['id'] = $this->setId();
	  		$this->json['method'] = $this->method;
	  		$this->json['params']['account']['issuerid'] = $this->issuerid;
	  		$this->json['params'][$this->customer]['name']['company'] = '';
	  		unset($this->json['params']['payment']['country']);
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
	   * Set  customer company parameter 
	   * 
	   * @param string $company
	   */
	  public function setCustomerCompany($company)
	  {
	  	   $this->json['params'][$this->customer]['name']['company'] = $company;
	  }
	  
	  /**
	   * Helper method that prepares json request for directoryRequest request
	   * 
	   * @return string
	   */
	  protected function prepareDirectoryRequest()
	  {
	  	    $this->jsonDirectory['id'] 	  = $this->setId();
	  	    $this->jsonDirectory['method'] = $this->directoryRequest;
	  	    $this->jsonDirectory['params'] = array();
	  	    
	  	    return $this->jsonDirectory;
	  }
	  
	  /**
	   * Shows the generated json request for createDirectory request
	   * so that the client can see what it has sent to server
	   * 
	   * @return string
	   */
	  public function showJsonDirectory()
	  {
	  	    return $this->encode($this->prepareDirectoryRequest());
	  }
	  
	  /** 
	   * Make directory request call
	   * This request returns a list of
       * banking issuers that support the iDEAL payment method.
       * 
       * @param void
       * @throws SkrillPsp_Exception
	   * @return object SkrillPsp_Response_Success|SkrillPsp_Response_Error
	   */
	  public function createDirectory()
	  {
	  		
	  	    if(is_null($this->getMerchant())) {
	  			throw new SkrillPsp_Exception("You should set endpoint, merchantId, channelId and payment method");
	  		}
	  	    
	  		$json = $this->prepareDirectoryRequest();
	  	    
	  	    return SkrillPsp_Http::post($this->url, $this->encode($json));
	  }
	  
	  /**
	   * Make PA request
	   * @throws SkrillPsp_Exception
	   * @return object SkrillPsp_Response_Success|SkrillPsp_Response_Error|SkrillPsp_ResponseErrorLevel
	   */
	  public function createPreAuthorization()
	  {
	  	   if(is_null($this->getMerchant())) {
	  		     throw new SkrillPsp_Exception("You should set endpoint, merchantId, channelId and payment method");
	  	   }
	  	  
	  	   return SkrillPsp_Http::post($this->url, $this->encode($this->json));
	  }
}