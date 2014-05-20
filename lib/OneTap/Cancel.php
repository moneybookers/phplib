<?php
/**
 * Class for OneTab Cancel requests
 * 
 * @package OneTab
 *
 */
class OneTap_Cancel extends OneTap_Status
{
	  private $method = 'cancel';
	  
	  /**
	   * Constructor
	   * Loads json request source and and decodes it in php array and sets id, token members
	   * 
	   * @param string $token
	   * @return void
	   */
	  public function __construct($token)
	  {
	  		$data = SkrillPsp_Json::getOneTapJson();
	  		$this->json = $this->decode($data, true);
	  		$this->json['id'] = $this->setId();
	  		$this->json['method'] = $this->method;
	  		$this->json['params']['account']['token'] = $token;
	  	 
	  		unset($this->json['params']['payment']);	  	    
	  }
}