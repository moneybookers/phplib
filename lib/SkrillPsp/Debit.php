<?php
/**
 * Class for debit requests
 * @package SkrillPsp
 */
class SkrillPsp_Debit extends SkrillPSP
{
	  private $token;
	  private $cvv;
	  private $ip;
	  
	  /**
	   * Constructor
	   * 
	   * Loads json request source and decodes it in php array and sets id member,
	   * checks for token and if it is set without cvv, unset card data
	   * 
	   * @param string $token optional
	   * @param string $cvv   optional
	   * @return void
	   */
	  public function __construct($token = null, $cvv = null)
	  {
	  	   $this->token = $token;
	  	   $this->cvv   = $cvv; 
	  	   $data = SkrillPsp_Json::getDebitJson();
	  	   $this->json = $this->decode($data, true);  
	  	   $this->json['id'] = $this->setId();
	  	    
	  	   if($this->token) {
	  	   		$this->json['params'][$this->account]['token'] = $token;
	  	   		unset($this->json['params'][$this->account]['cardholder']);
	  	   		unset($this->json['params'][$this->account]['number']);
	  	   		unset($this->json['params'][$this->account]['expiry']);
	  	   		unset($this->json['params'][$this->account]['cvv']);
	  	   }
		   // Add token + cvv
	  	   if($this->cvv)
	  	   {
	  	   	    $this->json['params'][$this->account]['cvv'] = $this->cvv; 
	  	   }
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
	  			case $this->identification:   // section
	  				foreach($value as $key => $value) {
	  					// validate section fields name
	  					if(!array_key_exists($key, $this->json['params'][$this->identification])) {
	  						throw new InvalidArgumentException("$key is not valid for identification section");
	  					}
	  
	  					$this->json['params'][$this->identification][$key] = $value;
	  				}
	  				break;
	  					
	  			case $this->payment:
	  				foreach($value as $key => $value) {
	  					// validate section fields name
	  					if(!array_key_exists($key, $this->json['params'][ $this->payment])) {
	  						throw new InvalidArgumentException("$key is not valid for payment section");
	  					}
	  					// Validator for setParameters method
	  					$this->validate($key, $value); 
	  
	  					$this->json['params'][$this->payment][$key] = $value;
	  				}
	  				break;
	  					
	  			case $this->account:
	  				if(empty($this->json['params'][$this->account]['token'])) {
	  					// remove token field
	  					unset($this->json['params'][$this->account]['token']);
	  					foreach ($value as $key => $value) {
	  						// validate section fields name
	  						if(!array_key_exists($key, $this->json['params'][$this->account])) {
	  							throw new InvalidArgumentException("$key is not valid for account section");
	  						}
	  				    	$this->validate($key, $value); // validator for field values
	  
	  						$this->json['params'][$this->account][$key] = $value;
	  					}
	  				}
	  		        else  // supports token + cvv request
	  				{
	  				    foreach ($value as $key => $value) {
	  				        if($key == 'cvv' && $value != '') {
	  				            // Validate CVV 
	  				            $this->validate($key, $value);
	  				        }
	  				        $this->json['params'][$this->account][$key] = $value;
	  				     }
	  				} 
	  				break;
	  					
	  			case $this->customer:
	  				foreach ($value as $key => $value) {
	  					// validate section fields name
	  					if(!array_key_exists($key, $this->json['params'][$this->customer])) {
	  						throw new InvalidArgumentException("$key is not valid for customer section");
	  					}
	  					foreach($value as $k => $v) {
	  						// validate sub-section fields name
	  						if(!array_key_exists($k, $this->json['params'][$this->customer][$key])) {
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
	  				throw new OutOfBoundsException("You should set predefined parameter group! (identification, payment,account,customer,merchant)");
	  		}
	  	}
	  }
	 
	  /**
	   * Sets a cardholder parameter
	   * @param string $cardholder
	   * @return SkrillPsp_Debit
	   */
	  public function setCardholder($cardholder)
	  {
	  	  if(is_null($this->token)) {
	  		  $this->json['params'][$this->account]['cardholder'] = $cardholder;
	  	  }
	  		
	  	  return $this;
	  }
	  
	  /**
	   * Sets a cardnumber parameter
	   * @param integer|string $number
	   * @return SkrillPsp_Debit
	   */
      public function setCardNumber($number)
	  {
	  	  if(is_null($this->token)) {
	  	       $number = $this->validateCardNumber($number);
	  		   if($number) {
	  		    	$this->json['params'][$this->account]['number'] = $number;
	  		   }
	  	  }
	  		return $this;
	  }
	  
	  /**
	   * Set an Expiry Date parameter
	   * @example Date format must be mm/yyyy
	   * <code>
	   * $objCredit->setExpiryDate('10/2013');
	   * </code>
	   * @param string $date
	   * @return SkrillPsp_Debit
	   */
	  public function setExpiryDate($date)
	  {
	  	  if(is_null($this->token)) {
	  		  $date = $this->validateExpiryDate($date);
	  		  if($date) {
	  			  $this->json['params'][$this->account]['expiry'] = $date;
	  		  }
	  	  }
	  		
	  		return $this;	  
	  }
	  
	  /**
	   * Set a cvv parameter
	   * @param number $cvv
	   * @return SkrillPsp_Debit
	   */
      public function setCVV($cvv)
	  {
	  	  if(is_null($this->token)) {
	  		  $cvv = $this->validateCVV($cvv);
	  		  if($cvv) {
	  			  $this->json['params'][$this->account]['cvv'] = $cvv;
	  		  }
	  	  } 
	  	  // support cvv + token
	  	  else {
	  	  	  $this->json['params'][$this->account]['cvv'] = $cvv;
	  	  }
	  		
	  	  return $this;
	  } 
	  
	  /***************************
	   * CUSTOMER GROUP METHODS
	  **************************/

	  /**
	   * Seta an email parameter
	   * @param string $email
	   * @return SkrillPsp_Debit
	   */
	  public function setCustomerEmail($email)
	  {
	  	if($this->isValidEmail($email)) { 
	  		$this->json['params'][$this->customer]['contact']['email'] = $email;
	  	}
	  
	  	return $this;
	  
	  }
	  
	  /**
	   * Set an ip address parameter
	   * @param string $ip
	   * @return SkrillPsp_Debit
	   */
	  public function setCustomerIp($ip)
	  {
	  	if($this->isValidIp($ip)) {
	  		$this->ip = $ip;
	  		$this->json['params'][$this->customer]['contact']['ip'] = $ip;
	  	}
	  	 
	  	return $this;
	  }
	  
	  /**
	   * Set Title of the end customer: Mr, Mrs, Ms
	   * @param string $title
	   * @return object SkrillPsp_Credit
	   */
	  public function setCustomerTitle($title)
	  {
	  	  $this->json['params']['customer']['name']['title'] = $title;
	  
	  	  return $this;
	  }
	  
	  /**
	   * Set customer’s first name
	   * @param string $name
	   * @return object SkrillPsp_Credit
	   */
	  public function setCustomerFirstName($name)
	  {
	  	$this->json['params']['customer']['name']['firstname'] = $name;
	  	 
	  	return $this;
	  }
	  
	  /**
	   * Set the customer’s surname
	   * @param string $name
	   * @return object SkrillPsp_Credit
	   */
	  public function setCustomerLastName($name)
	  {
	  	$this->json['params']['customer']['name']['lastname'] = $name;
	  	 
	  	return $this;
	  }
	  
	  /**
	   * Set the company the customer works for
	   * @param string $company
	   * @return object SkrillPsp_Credit
	   */
	  public function setCustomerCompany($company)
	  {
	  	$this->json['params']['customer']['name']['company'] = $company;
	  
	  	return $this;
	  }
	  
	  /**
	   * Set the customer’s first line of their address
	   * @param string $street
	   * @return object SkrillPsp_Credit
	   */
	  public function setCustomerStreet($street)
	  {
	  	$this->json['params']['customer']['address']['street'] = $street;
	  	 
	  	return $this;
	  }
	  
	  /**
	   * Set the customer’s postal/zip code
	   * @param int|string $zip
	   * @return object SkrillPsp_Credit
	   */
	  public function setCustomerZip($zip)
	  {
	  	$this->json['params']['customer']['address']['zip'] = $zip;
	  
	  	return $this;
	  }
	  
	  /**
	   * Set The Customer’s city
	   * @param string $city
	   * @return object SkrillPsp_Credit
	   */
	  public function setCustomerCity($city)
	  {
	  	$this->json['params']['customer']['address']['city'] = $city;
	  	 
	  	return $this;
	  }
	  
	  /**
	   * Set The customer’s state, county or local region
	   * @param string $state
	   * @return object SkrillPsp_Credit
	   */
	  public function setCustomerState($state)
	  {
	  	$this->json['params']['customer']['address']['state'] = $state;
	  
	  	return $this;
	  }
	  
	  /**
	   * Set Country code
	   * @param string $country
	   * @return object SkrillPsp_Credit
	   */
	  public function setCustomerCountry($country)
	  {
	  	$this->json['params']['customer']['address']['country'] = $country;
	  	 
	  	return $this;
	  }
	  
	  /**
	   * Set customer’s land line phone number
	   * @param integer|string $phone
	   * @return object SkrillPsp_Credit
	   */
	  public function setCustomerPhone($phone)
	  {
	  	$this->json['params']['customer']['contact']['phone'] = $phone;
	  	 
	  	return $this;
	  }
	  
	  /**
	   * Set customer’s mobile phone number
	   * @param string $mobile
	   * @return object SkrillPsp_Credit
	   */
	  public function setCustomerMobile($mobile)
	  {
	  	$this->json['params']['customer']['contact']['mobile'] = $mobile;
	  	 
	  	return $this;
	  }
	  
	  /*********************************
	   * END CUSTOMER GROUP SET METHODS
	  *********************************/	  

	  /**
	   * Checks json-rpc request object for required parameters and makes POST request
	   * @throws SkrillPsp_Exception
	   * @return object SkrillPsp_Response_Success|SkrillPsp_Response_Error|SkrillPsp_Response_ErrorLevel
	   */
	  public function makeCall()
	  {
		 if (is_null ( $this->getMerchant () )) {
			 throw new SkrillPsp_Exception ( "You should set endpoint, merchantId, channelId and payment method" );
		 }
		 
		 if(is_null($this->token)) { 
		 	unset($this->json['params'][$this->account]['token']);
		 /*	foreach ($this->json['params'][$this->account] as $key => $value) {
		 		if(empty($value)) {
		 			throw new SkrillPsp_Exception("$key is mandatory");
		 		}
		 	} */
		 } 
		 		 		 
		 return SkrillPsp_Http::post ( $this->url, $this->encode ( $this->json ) );
	  }
}
?>
