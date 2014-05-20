<?php
/**
 * SkrillPSP base class for common functionality
 * @package SkrillPsp
 * @category Library  
 * 
 */

/**
 * PHP 5.x.x SPL autoloading
 */
function autoload_library($class)
{
	require str_replace('_', DIRECTORY_SEPARATOR, $class) . '.php';
}

spl_autoload_register('autoload_library');

if (version_compare(PHP_VERSION, '5.2.1', '<')) {
	throw new SkrillPsp_Exception('PHP version >= 5.2.1 required');
}

abstract class SkrillPSP
{	

	/**
	 * Service endpoint
	 * @var string
	 */
	protected $url;
	
	/**
	 * JSON request data
	 * @var string
	 */
	protected $json;
	
	// Parameters group
	protected $identification = 'identification';
	protected $payment  	  = 'payment';
	protected $account  	  = 'account';
	protected $customer 	  = 'customer';
	protected $merchant 	  = 'merchant';
	
	protected $validGroups = array('identification', 'payment', 'account', 'customer', 'merchant');
	
	// Json error messages code/value
	protected $messages = array(
	   JSON_ERROR_NONE  => 'No error has occured',
	   JSON_ERROR_DEPTH => 'The maximum stack depth has been exceeded',
	   JSON_ERROR_STATE_MISMATCH => 'Invalid or malformed JSON',
	   JSON_ERROR_CTRL_CHAR => 'Control character error, possibly incorrectly encoded',
       JSON_ERROR_SYNTAX => 'Syntax error in json',
       JSON_ERROR_UTF8 => 'Malformed UTF-8 characters, possibly incorrectly encoded'
	);
	
	
	/**
	 * Retrieve the constructed (via SkrillPSP::setMerchant() or
	 * SrkrillPPS::setUri() methods) endpoint url 
	 * @return string $url
	 */
	protected function getMerchant()
	{
		return $this->url;
	}	
	
	/**
	 * Allows you the add json name/value outside of the SKRILL PSP predefined json name/values.
	 * Name/value pairs will be added in the params member of the JSON Request object.
	 * NOTE: You must not set valid parameter group as key of associative array
	 * @link http://www.jsonrpc.org/specification#request_object
	 * @see SkrillPSP::setParameters() 
	 * <code>
	 * $objDebit = new SkrillPsp_Debit();
	 * $objDebit->addParameters(array('country' => array('city' => 'Sofia'))); ==> {'country' : {'city':'Sofia'}}
	 * </code>
	 * @param mixed $params
	 * @throws OutOfBoundsException
	 */
	public function addParameters($params)
	{
		// check for assoc array
		if(is_array($params) && SkrillPsp_Util::isAssocArray($params)) {
			foreach($params as $key => $value) {
				if(!array_key_exists($key, $this->json['params'])) {
					$this->json['params'][$key] = $value;
				}
				else {
					throw new OutOfBoundsException("Not allowed to override predefined parameters!");
				}
			}
		}
		else {
			// check for index array
		   if(is_array($params)) {	
			  $arr = array_diff($params, $this->validGroups);
			  if(count($arr) === 0)
				  throw new OutOfBoundsException("Not allowed to override predefined parameters!");
		   }
		
		    if(in_array($params, $this->validGroups)) {
				  throw new OutOfBoundsException("Not allowed to override predefined parameters!");
			}
			
		    array_push($this->json['params'], $params); 
		   
		}
			
	}
	
	/*************************************************
	 * SETTER METHODS COMMON FOR THE CHILDREN CLASSES 
	 *************************************************/

	 /**
	  * Sets json  request identifier
	  * @param integer $length This parameters determine the length of generated string
	  * @return string $id
	  */
	 protected function setId($length = 10)
	 {
		 $id = substr(number_format(time() * rand(),0,'',''),0, $length);
		 return $id;
	 }
	
	/**
	 *
	 * Allows modification of service endpoint with
	 * different merchants, channels and payment methods
	 * 
	 * @param string $url
	 * @param string $merchantId
	 * @param string $channelId
	 * @param string $paymentMethod
	 * @throws SkrillPsp_Exception
	 */
	 public function setMerchantUrl($url, $merchantId, $channelId, $paymentMethod)
	 {
		 if($this->isValidUrl($url)) {
			 $this->url = $url. '/' . $merchantId . '/'.  $channelId . '/'. $paymentMethod;
		 } 
		 else {
			 throw new SkrillPsp_Exception("Please provide valid url");
		 }
			
	 }

	 /**
	  * Allows setting the service endpoint directly
	  * 
	  * @param string $uri
	  * @return void
	  */
	 public function setUri($uri)
	 {
	 	  if($this->isValidUrl($uri)) {
	 	      $this->url = $uri;
	 	  }
	 }
	
	/**
	 * Allows setting json values according to the Skrill PSP predefined structure + add addtional parameters(name/values) to the groups
	 * which are not present in the predefined structure
	 *  
	 * NOTE: $params must be an associative array in the following format
	 * <code>
	 * $params = array('identification' => array('transactionid' => 'CRM_F56A', 'customerid' => '122456', 'referenceid' => '5656565656'),
	 *                 'payment' 		=> array('amount' => '122', 'currency' => 'JPY', 'descriptor' => 'desc test'),
	 *                 'account' 		=> array('cardholder' => 'Peter Peter', 'number' => '1111111123', 'expiry' => '08/2010', 'cvv' => '412'));
	 *                 
	 * $obj->setParameters($params);
	 * </code>
	 * NOTE: The array key 'identification' for example must be a valid parameter group from SKRILL PSP API.
	 * In the array value which itself is associative array for example 'array('transactionid' => 'CRM_F56A', 'customerid' => '122456')' we define the parameters
	 * for the corresponding group. The key is json name and the value is json value array('transactionid' => 'CRM_F56A') becomes {'transactionid':'CRM_F56A'} 
	 * NOTE: With this method you will not be able to override the predefined parameter groups 
	 * @see SkrillPsp::addParameters()   
	 * @param array $params
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
						    throw new InvalidArgumentException("$key is not valid for identification section");	
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
				   if(empty($this->json['params'][$this->account]['token'])) {
				   	// remove token field
				   	unset($this->json['params'][$this->account]['token']);
					foreach ($value as $key => $value) {
						// validate section fields name
						if(!array_key_exists($key, $this->json['params']['account'])) {
							throw new InvalidArgumentException("$key is not valid for account section");
						}
						$this->validate($key, $value); // validator for field values
						
						$this->json['params']['account'][$key] = $value;
					 }
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
	 * Sets an amount parameter
	 * @param integer|string $amount
	 * @return SkrillPsp_PSP
	 */
	public function setAmount($amount)
	{
	    $this->json['params']['payment']['amount'] = $amount;
	    
		return $this;
	}
	
	/**
	 * Set a currency parameter
	 * @param string $cur
	 * @return SkrillPsp_PSP
	 */
	public function setCurrency($cur)
	{
		$cur = strtoupper($cur);
		if($this->validateCurrency($cur)) {
			$this->json['params'][$this->payment]['currency'] = $cur;
		}
	
		return $this;
	}
        /**
	 * Set a currency parameter
	 * @param string $cur
	 * @return SkrillPsp_PSP
	 */
	public function setUser($user)
	{
		
	    $this->json['params']['account']['username'] = $user;
	    
		return $this;
	}
        
        public function setPassword($pass)
	{
		
	    $this->json['params']['account']['pass'] = $pass;
	    
		return $this;
	}
	
	public function setDescriptor($descriptor)
	{
	     $this->json['params']['payment']['descriptor'] = $descriptor;

	     return $this;
	}
    
	// Identification group method parameters
	public function setTransactionId($trsId)
	{
		 $this->json['params']['identification']['transactionid'] = $trsId;
		 
		 return $this;
	}
	
	public function setCustomerId($customerId)
	{
		 $this->json['params']['identification']['customerid'] = $customerId;
		 
		 return $this;
	}
	
	/****************************************************
	 * END SETTERS
	 ***************************************************/
	
	/**
	 * Shows the generated json request
	 * so that the client can see what he/she has sent to server 
	 * @return string
	 */
	public function showJson()
	{
		return $this->encode($this->json);
	}
	
    /******************************************************
     * VALIDATION METHODS
     ******************************************************/
	/**
	 * Helper method for setParameters method
	 * Call dynamically validation methods
	 * 
	 * @see setParameters
	 * @param string $key
	 * @param mixed $value
	 */
	protected function validate($key, $value)
	{
		 $method = "validate" . ucfirst($key);
		 if(method_exists($this, $method)) {
		 	 $this->$method($value);
		 }
		 else {
		 	  $method = "isValid" . ucfirst($key);
		 	  if(method_exists($this, $method)) {
		 	  	   $this->$method($value);
		 	  }
		 }
		 
		 switch ($key)
		 {
		 	case 'expiry':
		 		$this->validateExpiryDate($value);
		 		break;
		 	case 'number':
		 		$this->validateCardNumber($value);
		 		break;
		 	case 'responseurl':
		 		$this->isValidUrl($value);
		 		break;
		 	case 'successurl':
		 		$this->isValidUrl($value);
		 		break;
		 	case 'errorurl':
               $this->isValidUrl($value);
               break;
               		 		
		 	default:
		 }
	}
	
	/**
	 * Validate amount parameter
	 * 
	 * @param mixed $amount
	 * @throws InvalidArgumentException
	 * @return mixed $amount
	 */
    protected function validateAmount($amount)
    {
    	if(empty($amount) || trim($amount) == "") {
    		throw new InvalidArgumentException("Expected amount to be set");
    	} 
    	  if(is_string($amount)) {
        	if(preg_match("/^[0-9]{2,12}$/", $amount)) {
        	 	return $amount;
        	}
        	else {
        		throw new InvalidArgumentException($amount . "is an invalid type. Digits only (2-12)");
        	}  
    	  }
    }
    
    /**
     * Validate currency parameter
     * @param string $cur
     * @throws InvalidArgumentException
     * @return string $cur
     */
    protected function validateCurrency($cur)
    {
	    if(empty($cur) || trim($cur) == "") {
		    throw new InvalidArgumentException("Expected currency to be set");
	    }
	    
    	if(preg_match("/^[A-Za-z]{3}$/", $cur)) {
    		return $cur;
    	}
    	else {
    		throw new InvalidArgumentException($cur . " is an invalid type. Use 3-char uppercase currency code");
    	} 
    }
    
    /**
     * Validates expriry date parameter
     * @param string $date
     * @throws InvalidArgumentException
     * @throws OutOfRangeException
     * @return string $date
     */
    protected function validateExpiryDate($date)
    {
    	 if(empty($date) || trim($date) == "") {
    	 	 throw new InvalidArgumentException("Expected expiry date to be set");
    	 }
    	 
    	 if(preg_match("/([0-9]{2})\\/([0-9]{4})/", $date, $matches)) {
    	 	   // Takes months. If year is longer than 4 chars it will be truncated automatically by preg_match
    	 	   $month = $matches[1];
    	 	   $year = $matches[2];
    	 	   if($month <= 0 || $month > 12) {
    	 	   	   throw new OutOfRangeException("Invalid month.Must be between (1-12)"); 
    	 	   }
    	 	   
    	 	   $date = $month.'/'.$year;
    	 	   return $date; 
    	 }
    	 else {
    	 	 throw new InvalidArgumentException($date . " is an invalid type. Use following format MM/YYYY instead");
    	 }
    }
    
    /**
     * Validate cvv parameter
     * @param string $cvv
     * @throws InvalidArgumentException
     * @return string $cvv
     */
    protected function validateCVV($cvv)
    {
    	if(empty($cvv) || trim($cvv) == "") {
    		 throw new InvalidArgumentException("Expected cvv to be set");
    	}
    	
    	if(preg_match("/^[0-9]{3,4}$/", $cvv)) { 
    		return $cvv;
    	}
    	else {
    		throw new InvalidArgumentException("CVV parameter " . $cvv . " is an invalid. Must be 3 or 4 digits long");
    	}
    }
    
    /**
     * Validates card number parameter
     * @param mixed $number
     * @throws InvalidArgumentException
     * @return mixed $number
     */
    protected function validateCardNumber($number)
    {
    	if(empty($number) || trim($number) == "")
    	{
    		 throw new InvalidArgumentException("Expected card number to be set.");
    	}
    	
    	if(preg_match("/^[0-9]{0,}$/", $number)) {
    		 return $number;
    	}
    	else {
    		 throw new InvalidArgumentException("Card number " . $number . " is an invalid.Must contain only digits");
    	}
    }
    
    /**
     * Validate QIWI user parameter for QIWI request
     * @param string $value
     * @throws InvalidArgumentException
     * @return void
     */
    protected function validateQiwiuser($value)
    {
    	 if(empty($value) || trim($value) == "") {
    	 	   throw new InvalidArgumentException("Qiwiuser is requred parameter");
    	 }
    	 
    	 if(!preg_match("/(tel:)\+[0-9]{1,}/", $value ,$matches)) { 
 			  throw new InvalidArgumentException("Qiwiuser value must start with prefix 'tel:'");	    	 
    	 }
    	 
    }
    
    /**
     * Validate url parameter
     * @param string $url
     * @throws InvalidArgumentException
     * @return boolean
     */
    protected function isValidUrl($url)
    {
    	if (filter_var($url, FILTER_VALIDATE_URL) !== false)
    	{
    		 return true;
    	}
    	else {
    		 throw new InvalidArgumentException("Url " . $url . "is invalid");
    	}
    }
    
    /**
     * Validate email parameter
     * @param string $email
     * @throws InvalidArgumentException
     * @return string $email
     */
    protected function isValidEmail($email)
    {
    	if(empty($email) || trim($email) == "")
    	{
    		throw new InvalidArgumentException("Expected email to be set.");
    	}
    	
    	$regex = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/';
    	
    	if(preg_match($regex, $email)) {
    		  return $email;
    	}
    	else 
    	{
    		throw new InvalidArgumentException("$email is not valid. Please provide valid email address");
    	}
    }
    
    /**
     * Validate ip parameter
     * @param string $ip
     * @throws InvalidArgumentException
     * @return string $ip
     */
    protected function isValidIp($ip)
    {
    	  if(empty($ip) || trim($ip) == "") {
    	  	   throw new InvalidArgumentException("Expected IP to be set");
    	  }
    	  
    	  if(filter_var($ip, FILTER_VALIDATE_IP)) {
    	  	   return $ip;
    	  }
    	  else {
    	  		throw new InvalidArgumentException("$ip is not valid. Please provide valid ip.");
    	  }
    }
    
    /**
     * Validates if a given value contains only alphabetical characters and digits
     * @param mixed $value
     * @param mixed $key
     * @throws InvalidArgumentException
     * @return mixed $value
     */
    protected function isAlnum($value, $key)
    {
    	 if(empty($value) || trim($value) == "") {
    		throw new InvalidArgumentException("Expected $key number to be set");
    	 }
    	
    	 if(!is_string($value) && !is_int($value) && !is_float($value)) {
    	 	  throw new InvalidArgumentException("$value is not valid $key value. Must be alphanum"); 
    	 }
    	 else {
    	 	 return $value;
    	 }
    }
    
    /**
     * Validate if given value contains only alphabetical characters
     * @param mixed $value
     * @param string $key
     * @throws InvalidArgumentException
     * @return string $value
     */
    protected function isAlpha($value, $key)
    {
    	 if('' === $value) {
    	 	 throw new InvalidArgumentException("Expected $key value to be set.");
    	 }
    	 
    	 $regexp = '/^[a-zA-Z\s\,\.]+$/';
    	  if(preg_match($regexp, $value))
    	  {
    	  	   return $value;
    	  }
    	  else {
    	  	  throw new InvalidArgumentException("$value is not valid $key value. Must be alpha");
    	  }
    	 
    }
    
    /**
     * Validate if given value contains only digits
     * @param mixed $value
     * @param string $key
     * @throws InvalidArgumentException
     * @return integer $value
     */
    protected function isDigit($value, $key)
    {
    	 if('' === $value) {
    	 	 throw new InvalidArgumentException("Expected $key value to be set.");
    	 }
    	 
    	 if(preg_match("/^[0-9]{0,}$/", $value)) {
    	      return $value;	  
    	 }
    	 else {
    	 	  throw new InvalidArgumentException("$value is not valid $key value. Must be digit.");
    	 }
    }
     
    
    /****************************************************************************
     * END VALIDATION METHODS
     ****************************************************************************/
    
    /**
     * Wrapper of php json_encode function.
     * Returns json representation of value (JSON encoded string)
     * @param mixed $value
     * @param number $option
     * @throws RuntimeException
     * @return string $result
     */
    public function encode($value, $option = 0)
    {
    	$result = json_encode($value);
    	
    	if($result) {
    		return $result;
    	}
    	
    	throw new RuntimeException($this->messages[json_last_error()]);
    }
    
    /**
     * Wrapper of the php decode_json function.
     * Takes a JSON encoded string and converts it into a PHP variable.  
     * 
     * @param string $json
     * @param bool $assoc Optional return stdClass if false and array if true
     * @throws RuntimeException
     * @return mixed Returns the value encoded in json in appropriate PHP type
     */
    public function decode($json, $assoc = false)
    {
    	$result = json_decode($json, $assoc);
    	
    	if($result) {
    		return $result;
    	}
    	
    	throw new RuntimeException($this->messages[json_last_error()]);
    }

    // Method for making post request to the payment gateway
    public function makeCall()
    {}
	
}

?>