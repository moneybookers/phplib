<?php
/**
 * Represent the JSON-RPC success response
 * @package SkrillPsp
 * @subpackage Response
 *
 */
class SkrillPsp_Response_Success
{
	  /**
	   * Response
	   * @var object
	   */
 	  private $response;
	  
	  /**
	   * Response flag
	   * @var bool
	   */
	  private $success;
	  
	  /**
	   * Result data
	   * @var array
	   */
	  private $data = array();
	  
	  /**
	   * Result data from payment group
	   * @var array
	   */
	  private $paymentProperties = array();
	  
	  /**
	   * Result data from identification group
	   * @var array
	   */
	  private $identificationProperties = array();
	  
	  /**
	   * Result data from account group
	   * @var array
	   */
	  private $accountProperties = array();
	
	
	  /**
	   * Constructor
	   * 
	   * @param object $response
	   * @return void
	   */
	  public function __construct($response) 
	  {
	  	  if($response->result->level == 0) {
              $this->success = true;
              $this->response = $response;
	  	  }
	  	  
	  	  $this->parse($response);
	  }
	  
	  /**
	   * Parse the JSON-RPC response object'
	   * 
	   * @param object $response
	   * @return void
	   */
	  private function parse($response)
	  {
	  	  if(isset($response->result)) {
	  		  $result = $response->result;
	  	  }
	  	
	  	if(isset($result) && is_object($result))
	  		$this->setResult($result);
	  
	  	if(isset($result->identification) && is_object($result->identification))
	  		$this->setIdentification($result->identification);
	  
	  	if(isset($result->payment) && is_object($result->payment))
	  		$this->setPayment($result->payment);
	  
	  	if(isset($result->account) && is_object($result->account))
	  			$this->setAccount($result->account);
	   
	   }
	  
	  /**
	   * Set result data
	   * 
	   * @param object $result
	   * @return void
	   */
	  protected function setResult($result)
	  {
	  	$properties = get_object_vars($result);
	  	foreach($properties as $key => $value)
	  	{
	  		if (!is_object($value)) {
	  			$this->data[$key] = $value;
	  		}
	  	}
	  	
	  }

	  /**
	   * PHP magic method
	   * Allows read level, code, method, type, message parameters
	   * like public properties of SkrillPsp_Success object
	   * 
	   * @param string $name
	   * @return mixed
	   */
	  public function __get($name)
	  {
	  	if(array_key_exists($name, $this->data)) {
	  		return $this->data[$name];
	  	}
	  	
	  }

	  /**
	   * Is the response successfull?
	   * @return boolean
	   */
	  public function isSuccess()
	  {
	  	  return $this->success;
	  }
	  
	  /**
	   * Is the response error?
	   * @return boolean
	   */
	  public function isError()
	  {
	  	   return false;
	  }
	  
	  /**
	   * Helps to determine type of response error object
	   * without need to use var_dump statements
	   *
	   * @return boolean
	   */
	  public function isErrorLevel()
	  {
	  	return false;
	  }
	  
	  /**
	   * Retrieves the request identifier
	   * @return mixed
	   */
	  public function getId()
	  {
	  	  return $this->response->id;
	  }
	  
	  /**
	   * Retrieves JSON-RPC protocol version
	   * 
	   * @return string
	   */
	  public function getVersion()
	  {
	  	   return $this->response->jsonrpc;  
	  }
	  
	  /**
	   * Retrieve the level response field
	   * @return int
	   */
	  public function getLevel()
	  {
	  	   return $this->response->result->level;
	  }
	  
	  /**
	   * Retrieves the code that dictates the status of the transaction
	   * @return integer
	   */
	  public function getCode()
	  {
	  	   return $this->response->result->code;
	  }
	  
	  /**
	   * Retrieves payment method
	   * 
	   * @return string
	   */
	  public function getMethod()
	  {
	  	    return $this->response->result->method;
	  }
	  
	  /**
	   * Retrieves type of the request
	   * 
	   * @return string
	   */
	  public function getRequestType()
	  {
	  	   return $this->response->result->type;
	  }
	  
	  /**
	   * Retrieves the message that indicates the status of the transaction
	   * 
	   * @return string
	   */
	  public function getMessage()
	  {
	  	    return $this->response->result->message;
	  }

	  /**
	   * Used in alternative payment methods
	   * Retireves redirecturl
	   * 
	   * @return string
	   */
	  public function getRedirectUrl()
	  {
	  	 return isset($this->response->result->processing->redirecturl) ? $this->response->result->processing->redirecturl : 'null';
	  }
	  
	  /**
	   * Used in alternative payment methods
	   * Retireves time stamp
	   * 
	   * @return string
	   */
	  public function getTimeStamp()
	  {
	  	   return isset($this->response->result->processing->timestamp) ? $this->response->result->processing->timestamp : 'null';
	  }
	  
	  
	  /**
	   * Set identification response parameters
	   * 
	   * @param object $identification
	   * @return void
	   * 
	   */
	  protected function setIdentification($identification)
	  {
	  	   $properties = get_object_vars($identification);
	  	   foreach ($properties as $key => $value)
	   	   {
	  		    $this->identificationProperties[$key] = $value;
	  	   }
	  }
	  
	  /**
	   * Retrieve identification response parameters from JSON-RPC Response object
	   * @return array
	   */
	  public function getIdentification()
	  {
	  		return $this->identificationProperties;
	  }
	  
	  /**
	   * Set payment response parameters
	   * @param object  $payment
	   * @return void
	   */
	  protected function setPayment($payment)
	  {
	  	  $properties = get_object_vars($payment);
	  	  foreach ($properties as $key => $value)
	  	  {
	  		 $this->paymentProperties[$key] = $value;
	  	  }
	  }
	  
	  /**
	   * Retrieve payment response parameters from JSON-RPC Response object
	   * @return array
	   */
	  public function getPayment()
	  {
	  	    return $this->paymentProperties;
	  }

	  /**
	   * Set account response parameter
	   * @param object $account
	   * @return void
	   */
	  protected function setAccount($account)
	  {
	  	   $properties = get_object_vars($account);
	  	   foreach ($properties as $key => $value)
	  	   {
	  	   	     $this->accountProperties[$key] = $value;
	  	   }
	  }
	  
	  /**
	   * Retrieve account response parameters for JSON-RPC Response object
	   * @return array
	   */
	  public function getAccount()
	  {
	  	   return $this->accountProperties;   
	  }
	  
	  /**
	   * Retrieve the generated token
	   * @return string|null
	   */
	  public function getToken()
	  {
	  	    return isset($this->response->result->account->token) ? $this->response->result->account->token : 'null';
	  }
	  
	  /**
	   * Retrieve the generated bin 
	   * 
	   * @return string|null
	   */
	  public function getBin()
	  {
	  	   return isset($this->response->result->account->bin) ? $this->response->result->account->bin : 'null';
	  }
	  
	  /**
	   * Retrieve the generated last
	   * 
	   * @return string|null
	   */
	  public function getLast()
	  {
	  	     return isset($this->response->result->account->last) ? $this->response->result->account->last : 'null';
	  }
	  
	  /**
	   * Retrieve the generated expiry month
	   * 
	   * @return string|null
	   */
	  public function getExpiryMonth()
	  {
	  	    return isset($this->response->result->account->expiry_month) ? $this->response->result->account->expiry_month : 'null';
	  }
	  
	  /**
	   * Retrieve the generated expiry year
	   * 
	   * @return string|null
	   */
	  public function getExpiryYear()
	  {
	  	    return isset($this->response->result->account->expiry_year) ? $this->response->result->account->expiry_year : 'null';
	  }
	  
	  /**
	   * Retrieve the generated masked
	   * 
	   * @return string|null
	   */
	  public function getMasked()
	  {
	  	    return isset($this->response->result->account->masked) ? $this->response->result->account->masked : 'null';
	  }
	  
	  /**
	   * Retrieve a unique reference generated by Skrill’s payment platform to identify the transaction
	   * 
	   * @return string|null
	   */
	  public function getReferenceId()
	  {
	       return isset($this->response->result->identification->uniqueid) ? $this->response->result->identification->uniqueid : 'null';  	
	  }
	  
	  /**
	   * Retrieves response from server in json format
	   * 
	   * @return string
	   */
	  public function getJsonResponse()
	  {
	  	   return json_encode($this->response);
	  }
	  
}