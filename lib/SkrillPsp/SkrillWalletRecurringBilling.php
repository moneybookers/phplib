<?php
/**
 * Class for SkrillWallet Recurring Billing requests
 *  
 * @package SkrillPsp
 *
 */
class SkrillPsp_SkrillWalletRecurringBilling extends SkrillPsp_SkrillWalletPreauthorization
{
	  protected $recurrence = 'recurrence';
	  
	  /**
	   * Constructor
	   *
	   * Decodes json source in php array and sets id and method members of json request
	   * @return void
	   */
	  public function __construct()
	  {
	  	   $data = SkrillPsp_Json::getSkrillWalletRecurringBillingJson();
	  	   $this->json = $this->decode($data, true);
	  	   
	  	   if(empty($this->json['params']['merchant'])) {
	  	   	    unset($this->json['params']['merchant']);
	  	   }
	  	   
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
	  					$this->json['params']['payment'][$key] = $value;
	  	
	  				}
	  				break;
	  				
	  			case $this->recurrence:
	  				 foreach ($value as $key => $value) {
	  				 	  if(!array_key_exists($key, $this->json['params']['recurrence'])) {
	  				 	  	   throw new InvalidArgumentException("$key is not valid for recurrence section.");
	  				 	  }
	  				 	  $this->json['params']['recurrence'][$key] = $value;
	  				 }
	  				break;
	  	
	  			case $this->frontend :
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
	  					if(empty($value)) {
	  						$this->json['params'][$this->merchant] = new stdClass();
	  					}
	  					else {
	  						$this->json['params'][$this->merchant][$key] = $value;
	  					}
	  				}
	  				break;
	  	
	  			default:
	  				throw new OutOfBoundsException("You should set predefined parameter group!");
	  		}
	  	}
	  }
	  
      /***************************
       * Recurrence setter methods
       ***************************/
	  /**
	   * Set rec_amount parameter
	   * 
	   * @param mixed $amount
	   * @return object SkrillPsp_SkrillWalletRecurringBilling
	   */
	  public function setRecurrenceAmount($amount)
	  {
	  	    $this->json['params']['recurrence']['rec_amount'] = $amount;
	  	    
	  	    return $this;
	  }
	  
	  /**
	   * Set rec_start_date parameter
	   * 
	   * @param string $date
	   * @return object SkrillPsp_SkrillWalletRecurringBilling
	   */
	  public function setRecurrenceStartDate($date)
	  {
	  	    $this->json['params']['recurrence']['rec_start_date'] = $date;
	  	    
	  	    return $this;
	  }
	  
	  /**
	   * Set rec_end_date parameter
	   * 
	   * @param string $date
	   * @return object SkrillPsp_SkrillWalletRecurringBilling
	   */
	  public function setRecurrenceEndDate($date)
	  {
	  	    $this->json['params']['recurrence']['rec_end_date'] = $date;
	  	    
	  	    return $this;
	  }

	  /**
	   * Set rec_cycle parameter
	   * 
	   * @param string $cycle
	   * @return object SkrillPsp_SkrillWalletRecurringBilling
	   */
	  public function setRecurrenceCycle($cycle)
	  {
	  	    $this->json['params']['recurrence']['rec_cycle'] = $cycle;
	  	    
	  	    return $this;
	  }
	  
	  /**
	   * Set rec_period parameter
	   * 
	   * @param mixed $period
	   * @return object SkrillPsp_SkrillWalletRecurringBilling
	   */
	  public function setRecurrencePeriod($period)
	  {
	  	    $this->json['params']['recurrence']['rec_period'] = $period;
	  	    
	  	    return $this;
	  }
	  
	  /**
	   * Set rec_grace_period parameter
	   * 
	   * @param int $gracePeriod
	   * @return object SkrillPsp_SkrillWalletRecurringBilling
	   */
	  public function setRecurrenceGracePeriod($gracePeriod)
	  {
	  	    $this->json['params']['recurrence']['rec_grace_period'] = $gracePeriod;
	  	    
	  	    return $this;
	  }
	  
	  /**
	   * Set rec_status_url
	   * @param string $url
	   * @return object SkrillPsp_SkrillWalletRecurringBilling
	   */
	  public function setRecurrenceStatusUrl($url)
	  {
	  	   $this->json['params']['recurrence']['rec_status_url']= $url;
	  	   
	  	   return $this;
	  }
	  
	  /**
	   * Set res_status_url2 parameter
	   * 
	   * @param string $url
	   * @return object SkrillPsp_SkrillWalletRecurringBilling
	   */
	  public function setRecurrenceStatusUrl2($url)
	  {
	  	    $this->json['params']['recurrence']['res_status_url2'] = $url;
	  	    
	  	    return $this;
	  }
	  
	  /**
	   * Checks json-rpc request object for required parameters and makes POST request
	   * @throws SkrillPsp_Exception
	   * @return SkrillPsp_Response_Success|SkrillPsp_Response_Error
	   */	  
	  public function makeCall()
	  {
	  		if(is_null($this->getMerchant())) {
	  			throw new SkrillPsp_Exception("You should set endpoint, merchantId, channelId and payment method");
	  		}
	  	 
	  		return SkrillPsp_Http::post($this->url, $this->encode($this->json));
	  }
}