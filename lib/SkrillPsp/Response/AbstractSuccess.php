<?php
class SkrillPsp_Response_AbstractSuccess
{
	  protected $response;
	  protected $success;
	  
	  public function __construct($response)
	  {
	  	    if($response->result->level == 0)
	  	    {
	  	    	 $this->success = true;
	  	    	 $this->response = $response;
	  	    }
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
}