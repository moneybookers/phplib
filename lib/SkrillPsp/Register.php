<?php
/**
 * Class for Register request
 * @package SKrillPsp
 */
 class SkrillPsp_Register extends SkrillPSP
 {
 	  
 	  /**
 	  * Constructor
 	  * 
 	  * Loads json request source and
 	  * decodes it in php array and sets id member
 	  * 
 	  * @return void  
 	  */
 	  public function __construct()
 	  {
 	  		$data = SkrillPsp_Json::getRegisterJson();
 	  		$this->json = $this->decode($data, true);
 	  	  	$this->json['id'] = $this->setId();			 
 	  }
 	  
 	  /**
 	   * Sets cardnumber parameter
 	   * @param integer $number
 	   * @return SkrillPsp_Register
 	   */
 	  public function setCardNumber($number)
	  {
	  		$number = $this->validateCardNumber($number);
	  		if($number) {
	  			$this->json['params'][$this->account]['number'] = $number;
	  		}

	  		return $this;
	  }
	  
	  /**
	   * Set an Expiry Date parameter
	   * @example Date format must be mm/yyyy
	   * @param string $date
	   * <code>
	   *   $objPre->setExpiryDate('10/2013');
	   * </code>
	   * @return SkrillPsp_Register
	   */
 	  public function setExpiryDate($date)
	  {
			$date = $this->validateExpiryDate ( $date );
			if ($date) {
				$this->json ['params'] [$this->account] ['expiry'] = $date;
			}
			
			return $this;
	  }
	  
	  /**
	   * Sets CVV parameter
	   * @param number $cvv
	   * @return SkrillPsp_Register
	   */
	  public function setCVV($cvv)
	  {
	  		$cvv = $this->validateCVV($cvv);
	  		if($cvv) {
	  			$this->json['params'][$this->account]['cvv'] = $cvv;
	  		}
	  		
	  		return $this;
	  }
	  
	  /**
	   * Overrides parent SkrillPSP::setParameters() method
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
	  			case $this->account:
	  				foreach ($value as $key => $value) {
	  					// validate section fields name
	  					if(!array_key_exists($key, $this->json['params']['account'])) {
	  						throw new InvalidArgumentException("$key is not valid for account section");
	  					}
	  					$this->validate($key, $value); // validator for field values
	  					$this->json['params'][$this->account][$key] = $value;
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
	   * Overrides method from parent class that should not be used in this class
	   * @throws OutOfBoundsException
	   */
	  public function setTransactionId() 
	  {
	  	    throw new OutOfBoundsException("Register request does not support transactionId parameter");
	  }

	  /**
	   * Overrides method from parent class that should not be used in this class
	   * @throws OutOfBoundsException
	   */
	  public function setCustomerId() 
	  {
	  	   throw new OutOfBoundsException("Register request does not support customerId parameter");
	  }
	  
	  /**
	   * Checks json-rpc request object for required parameters and makes POST request
	   * @throws SkrillPsp_Exception
	   * @return SkrillPsp_Response_Success|SkrillPsp_Response_Error|SkrillPsp_Response_ErrorLevel
	   */	  
	  public function makeCall()
      {
		 if (is_null ( $this->getMerchant () )) {
			 throw new SkrillPsp_Exception ( "You should set endpoint, merchantId, channelId and payment method" );
		 }
		 
		 return SkrillPsp_Http::post ( $this->url, $this->encode ( $this->json ) );
	  } 
 }
?>
