<?php
/**
 * Class for credit request
 * 
 * @package SkrillPsp 
 *
 */

class SkrillPsp_Credit extends SkrillPSP
{
	private $token;
	
	/**
	 * Constructor
	 * 
	 * Loads json request source and decodes it in php array and sets id member,
	 * checks for token and if it is set, unset card data
	 * 
	 * @param string $token optional
	 * @return void
	 */
    public function __construct($token = null)
    {
         $this->token = $token;
	 
         $data = SkrillPsp_Json::getCreditJson();
         $this->json = $this->decode($data, true);
	     $this->json['id'] = $this->setId();
	     if($this->token) {
	    	  $this->json['params'][$this->account]['token'] = $this->token;
	    	  unset($this->json['params'][$this->account]['cardholder']);
	    	  unset($this->json['params'][$this->account]['number']);
	    	  unset($this->json['params'][$this->account]['expiry']);
	    	  unset($this->json['params'][$this->account]['cvv']);
	     } 
    }
	
	/**
	 * Sets a cardholder parameter
	 * @param string $cardholder
	 * @return SkrillPsp_Credit
	 */
	public function setCardholder($cardholder)
	{
		if(is_null($this->token)) {
		    $this->json['params'][$this->account]['cardholder'] = $cardholder;
		}
		
		return $this;
	}
	
	/**
	 * Set a cardnumber parameter
	 * @param integer $number
	 * @return SkrillPsp_Credit
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
	 * @return SkrillPsp_Credit
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
	 * Sets CVV parameter
	 * @param number $cvv
	 * @return SkrillPsp_Credit
	 */
	public function setCVV($cvv)
	{
		if(!is_null($this->token)) {
			$cvv = $this->validateCVV($cvv);
			if($cvv) {
				$this->json['params'][$this->account]['cvv'] = $cvv;
			}
		}

		return $this;
	} 
    

    /***************************
     * CUSTOMER GROUP METHODS
     **************************/
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
    
    /**
     * Sets an email parameter
     * @param string $email
     * @return SkrillPsp_Credit
     */
    public function setCustomerEmail($email)
    {
    	if($this->isValidEmail($email)) {
    		$this->json['params'][$this->customer]['contact']['email'] = $email;
    	}
    
    	return $this;
    }
    
    /**
     * Set ip parameter
     * @param string $ip
     * @return SkrillPsp_Credit
     */
    public function setCustomerIp($ip)
    {
    	if($this->isValidIp($ip)) {
    		$this->json['params'][$this->customer]['contact']['ip'] = $ip;
    	}
    
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
    	
        if(is_null($this->getMerchant())) {
       	    throw new SkrillPsp_Exception("You should set endpoint, merchantId, channelId and payment method");
        }   

        if(empty($this->token)) {
        	 unset($this->json['params'][$this->account]['token']);
        	 foreach ($this->json['params'][$this->account] as $key => $value)
        	 {
        	 	  if(empty($value)) {
        	 	  	   throw new SkrillPsp_Exception("$key is mandatory. Unless you provide valid token.");
        	 	  }
        	 }
        }   
                   	
        return SkrillPsp_Http::post($this->url, $this->encode($this->json));
    }
}
?>
