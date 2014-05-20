<?php
require_once 'SkrillPSP.php';

/**
 * Abstract class for alternative payment classes
 * @package SkrillPsp
 * @category Library
 *
 */
abstract class SkrillPSPAlternativePayment extends SkrillPSP
{
	// add additional parameter group for alternative payments
	protected $frontend = 'frontend';
	
	/**
	 * Check for required fields
	 * @param array $params
	 * @throws InvalidArgumentException
	 * @return boolean
	 */
	protected function prepare($params)
	{
		foreach ($params as $key => $value)
		{
			if(empty($value)) {
				throw new InvalidArgumentException("$key is required");
			}
		}
	
		return true;
	}
	
	/**
	 * Override setParameters method in parent class
	 * because of different request parameters
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
					throw new OutOfBoundsException("You should set predefined parameter group! (identification, payment,account,customer,frontend,merchant)");
			}
		}
	}
	
    // Frontend section methods
    /**
     * Set frontend language parameter
     * @param string $lang
     * @return object SkrillPSPAlternativePayment
     */
	public function setFrontendLanguage($lang)
	{
		$this->json['params']['frontend']['language'] = $lang;
	
		return $this;
	}
	
	/**
	 * Set frontend responseurl parameter
	 * @param string $url
	 * @return object SkrillPSPAlternativePayment
	 */
	public function setFrontendResponseUrl($url)
	{
		$this->json['params']['frontend']['responseurl'] = $url;
		 
		return $this;
	}
	
	/**
	 * Set frontend successurl parameter
	 * @param string $url
	 * @return object SkrillPSPAlternativePayment
	 */
	public function setFrontendSuccessUrl($url)
	{
		$this->json['params']['frontend']['successurl'] = $url;
	
		return $this;
	}
	
	/**
	 * Set frontend errorurl parameter
	 * @param string $url
	 * @return object SkrillPSPAlternativePayment
	 */
	public function setFrontendErrorUrl($url)
	{
		
		$this->json['params']['frontend']['errorurl'] = $url;
	
		return $this;
	}
	// End of frontend section
	
	/***************************
	 * Customet section methods
	 ***************************/
	// Customer name section
	/**
	 * Set the customer salutation parameter
	 * @param string $salut
	 * @return object SkrillPSPAlternativePayment
	 */
	public function setCustomerSalutation($salut)
	{
		  $this->json['params']['customer']['name']['salutation'] = $salut;
		  
		  return $this;
	}
	
	/**
	 * Set customer firstname parameter
	 * 
	 * @param string $firstname
	 * @return object SkrillPSPAlternativePayment
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
	 * @return object SkrillPSPAlternativePayment
	 */
	public function setCustomerLastName($lastname)
	{
		  $this->json['params']['customer']['name']['lastname'] = $lastname;
		  
		  return $this;
	}
	// End customer name section
	
	// Customer address section
	/**
	 * Set customer street parameter
	 * 
	 * @param string $street
	 * @return object SkrillPSPAlternativePayment
	 */
	public function setCustomerStreet($street)
	{
		 $this->json['params']['customer']['address']['street'] = $street;
		 
		 return $this;
	}
	
	/**
	 * Set customer zip parameter
	 * 
	 * @param mixed $zip
	 * @return object SkrillPSPAlternativePayment
	 */
	public function setCustomerZip($zip)
	{
		 $this->json['params']['customer']['address']['zip'] = $zip;
		 
		 return $this;
	}
	
	/**
	 * Set customer city parameter
	 * 
	 * @param string $city
	 * @return object SkrillPSPAlternativePayment
	 */
	public function setCustomerCity($city)
	{
		  $this->json['params']['customer']['address']['city'] = $city;
		  
		  return $this;
	}
	
	/**
	 * Set customer state parameter
	 * 
	 * @param string $state
	 * @return object SkrillPSPAlternativePayment
	 */
	public function setCustomerState($state)
	{
		 $this->json['params']['customer']['address']['state'] = $state;
		 
		 return $this;
	}
	
	/**
	 * Set customer country parameter
	 * 
	 * @param string $country
	 * @return object SkrillPSPAlternativePayment
	 */
	public function setCustomerCountry($country)
	{
		  $this->json['params']['customer']['address']['country'] = $country;
		  
		  return $this;
	}
	// End customer address section
	
	// Customer contact section
	/**
	 * Set customer email parameter
	 * 
	 * @param string $email
	 * @return object SkrillPSPAlternativePayment
	 */
	public function setCustomerEmail($email)
	{
		 if($this->isValidEmail($email)) {
		 	 $this->json['params']['customer']['contact']['email'] = $email;
		 }
		 
		 return $this;
	}

	/**
	 * Set customer mobile parameter
	 * 
	 * @param string $mobile
	 * @return object SkrillPSPAlternativePayment
	 */
	public function setCustomerMobile($mobile)
	{
		 $this->json['params']['customer']['contact']['mobile'] = $mobile;
		 
		 return $this;
	}
	
	/**
	 * Set customer phone parameter
	 * 
	 * @param string $phone
	 * @return object SkrillPSPAlternativePayment
	 */
	public function setCustomerPhone($phone)
	{
		 $this->json['params']['customer']['contact']['phone'] = $phone;
		 
		 return $this;
	}
	
	/**
	 * Set customer ip parameter
	 * 
	 * @param string $ip
	 * @return object SkrillPSPAlternativePayment
	 */
	public function setCustomerIp($ip)
	{
		 if($this->isValidIp($ip)) {
		 	$this->json['params']['customer']['contact']['ip'] = $ip;
		 }
		 
		 return $this;
	}
	//End customer contact section

}