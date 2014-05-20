<?php
/**
 * Class for handling error response with structure different from JSON-RPC standard Error object
 * @package SkrillPsp
 * @subpackage Response
 */
class SkrillPsp_Response_ErrorLevel
{
	/**
	 * Error response 
	 * @var object
	 */
	  private $response;
	  
	  /**
	   * Errror flag 
	   * @var bool
	   */
	  private $error;
	  
	  /**
	   * Constructor
	   * 
	   * @param object $response
	   * @return void
	   */
	  public function __construct($response)
	  {
	       $this->response = $response;	   
	       $this->error = true;
	  }
	  
	  /**
	   * Is the response error level?
	   * @return bool
	   */
	  public function isErrorLevel()
	  {
	  	   return $this->error;
	  }
	  
	  /**
	   * Helps to determine type of response error object
	   * without need to use var_dump statements
	   * 
	   * @return boolean
	   */
	  public function isError()
	  {
	  	   return false; 
	  }
	  
	  /**
	   * Is the response success?
	   * @return boolean
	   */
	  public function isSuccess()
	  {
	       return false;
	  }
	  
	  /**
	   * Retrieve request identifier
	   * @return mixed
	   */
	  public function getId()
	  {
	  	return $this->response->id;
	  }
	  
	  /**
	   * Retrieve the JSON-RPC version
	   *
	   * @return string
	   */
	  public function getVersion()
	  {
	  	return $this->response->jsonrpc;
	  }
	  
	  /**
	   * The error level that the response is coming from
	   *
	   * @return string
	   */
	  public function getErrorLevel()
	  {
	  	   return $this->response->result->level;
	  }
	  
	  /**
	   * Response code returned from the acquirer or card issuer
	   *
	   * @return integer
	   */
	  public function getErrorCode()
	  {
	  	   return $this->response->result->code;
	  }
	  
	  /**
	   * Retrieve method response parameter
	   * 
	   * @return string
	   */
	  public function getMethod()
	  {
	  	    return $this->response->result->method;
	  }
	  
	  /**
	   * Retrieve an abbreviation of the type of request that was invoked in the merchant request
	   * 
	   * @return string
	   */
	  public function getType()
	  {
	  	   return $this->response->result->type;
	  }
	  
	  /**
	   * Provides a short description of the error
	   *
	   * @return string
	   */
	  public function getErrorMessage()
	  {
	  	   return $this->response->result->message;
	  }
	  
	  /**
	   * Provides advice for next step to take
	   *
	   * @return string
	   */
	  public function getAdvice()
	  {
	  	   return $this->response->result->advice;
	  }
	  
	  /**
	   * Retrieves identification group
	   * 
	   * @return object
	   */
	  public function getIdentification()
	  {
	  	    return isset($this->response->result->identification) ? $this->response->result->identification : 'null';
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