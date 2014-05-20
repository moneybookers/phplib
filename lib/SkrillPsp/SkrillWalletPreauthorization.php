<?php
/**
 * Class for Skirll Wallet Preauthorization requests
 * @package SkrillPsp
 *
 */
class SkrillPsp_SkrillWalletPreauthorization extends SkrillPSPAlternativePayment
{  
	 /**
	  * Constructor
	  *
	  * Decodes json source in php array and sets id and method members of json request
	  * @return void
	  */
     public function __construct()
     { 
     	   $data = SkrillPsp_Json::getSkrillWalletPreauthorization();
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
     			//		$this->validate($key, $value); // validator for field values
     					$this->json['params']['payment'][$key] = $value;

     				}
     				break;

                        case $this->account:
                            foreach($value as $key => $value) {
                            // validate section fields name
                            if(!array_key_exists($key, $this->json['params']['account'])) {
                              throw new InvalidArgumentException("$key is not valid for account section");
                            }
                        //    $this->validate($key, $value); // validator for field values
                            $this->json['params']['account'][$key] = $value;

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
     
     public function setPaymentMethods(array $methods)
     {
     	   $this->json['params']['payment']['payment_methods'] = $methods;
     }
     
     /**************************
      * Frontend setter method
      **************************/
     /**
      * Set the frontend new_window_redirect parameter
      * @param string $flag
      * @return object SkrillPsp_SkrillWalletPreauthorization
      */
     public function setFrontendNewWindowRedirect($flag)
     {
     	   $this->json['params']['frontend']['new_window_redirect'] = $flag;
     	   
     	   return $this;
     }
     
     /**
      * Set frontend confirmation_note parameter
      * @param string $note
      * @return object SkrillPsp_SkrillWalletPreauthorization
      */
     public function setFrontendConfirmationNote($note)
     {
     	  $this->json['params']['frontend']['confirmation_note'] = $note;
     	  
     	  return $this;
     }
     
     /**
      * Set frontend logo_url parameter
      * @param string $url
      * @return object SkrillPsp_SkrillWalletPreauthorization
      */
     public function setFrontendLogoUrl($url)
     {
     	if($this->isValidUrl($url)) {
     		$this->json['params']['frontend']['logo_url'] = $url;
     	}
     	 
     	return $this;     	  
     }
     
     /**
      * Set frontend rid parameter
      * Unique referral ID or email of an affiliate from
      * which the customer is referred
      * @param string $rid
      * @return object SkrillPsp_SkrillWalletPreauthorization
      */
     public function setFrontendRid($rid)
     {
     	  $this->json['params']['frontend']['rid'] = $rid;
     	  
     	  return $this;
     }
     
     /**
      * Set frontend ext_ref_id parameter
      * This is an additional identifier to track your affiliates
      * @param string $id
      * @return object SkrillPsp_SkrillWalletPreauthorization
      */
     public function setFrontendExtRefId($id)
     {
     	  $this->json['params']['frontend']['ext_ref_id'] = $id;
     	  
     	  return $this;
     }
     
     /**
      * Set frontend detail_description parameter
      * @param string $description
      * @return object SkrillPsp_SkrillWalletPreauthorization
      */
     public function setFrontendDetailDescription($description)
     {
     	  $this->json['params']['frontend']['detail_descriptions'] = $description;

     	  return $this;
     }
     

     /**
      * Set frontend amount_details parameter
      * @param mixed $details
      * @return object SkrillPsp_SkrillWalletPreauthorization
      */
     public function setFrontendAmountDetails($details)
     {
     	   $this->json['params']['frontend']['amount_details'] = $details;
     	   
     	   return $this;
     }
  
     /******************************
      * END Frontend setter methods
      *****************************/     
     /**
      * Set customer title parameter
      * @param string $title
      * @return object SkrillPsp_SkrillWalletPreauthorization
      */
     public function setCustomerTitle($title)
     {
     	   $this->json['params']['customer']['name']['title'] = $title;
     	   
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