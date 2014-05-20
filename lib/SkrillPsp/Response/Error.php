<?php
/**
 * Reperesent JSON-RPC error object
 * @package SkrillPsp
 * @subpackage Response
 *
 */
class SkrillPsp_Response_Error
{
	/**
	 * Error response
	 * @var object
	 */
	 private $response; 
	 
	 /**
	  * Error flag
	  * @var bool
	  */
	 private $error;
	 
	 /**
	  * Error data
	  * @var array
	  */
	 private $data = array();	 
	 
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
	 	$this->parse($this->response);
	 }	 
	 
	 /**
	  * 
	  * @param object $response
	  * @return void
	  */
	 private function parse($response)
	 {
	 	  $this->setErrorData($response->error->data);
	 }
	 
	 /**
	  * Is the response error?
	  * @return bool
	  */
	 public function isError()
	 {
	 	  return $this->error;
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
	  * Set error data
	  * 
	  * @param object $error
	  * @return void
	  */
	 protected function setErrorData($error)
	 {
	 	  $properties = get_object_vars($error);
	 	  foreach ($properties as $key => $value) {
	 	  	   $this->data[$key] = $value;
	 	  }
	 }
	 
	 /**
	  * Get error data
	  * NOTE: return CODE and MESSAGE members of JSON-RPC Error object
	  * @return object
	  */
	 public function getError()
	 {
	 	  return $this->response->error;
	 }
	 
	 /**
	  * Get error data
	  * NOTE: returns DATA member of JSON-RPC Error object
	  * 
	  * @return array
	  */
	 public function getErrorData()
	 {
	 	  return $this->data;
	 }
	 
	 /**
	  * Provides advice for next step to take
	  * 
	  * @return string
	  */
	 public function getAdvice()
	 {
	 	 return $this->data['advice'];
	 }
	 
	 /**
	  * Provides a more detailed description of error
	  * 
	  * @return string
	  */
	 public function getErrorDataMessage() 
	 {
	 	   return $this->data['errormessage'];
	 }
	 
	 /**
	  * The error level that the response is coming from 
	  * 
	  * @return string
	  */
	 public function getErrorLevel()
	 {
	 	  return $this->data['level'];
	 }
	 
	 /**
	  * Response code returned from the acquirer or card issuer
	  * 
	  * @return integer
	  */
	 public function getErrorCode()
	 {
	 	  return isset($this->response->error->code) ? $this->response->error->code : 'null';
	 }
	 
	 /**
	  * Provides a short description of the error
	  * 
	  * @return string
	  */
	 public function getErrorMessage()
	 {
	 	  return $this->response->error->message;
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