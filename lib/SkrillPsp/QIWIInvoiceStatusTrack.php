<?php
/**
 * Class for QIWI Invoice Status Track requests
 * @package SkrillPsp
 *
 */
class SkrillPsp_QIWIInvoiceStatusTrack extends SkrillPsp_QIWICancelInvoice
{
	 private $method = 'invoiceStatustrack';
	 
	 /**
	  * Constructor
	  *
	  * Loads json request source and decodes it in php array and sets id and method members
	  */
	 public function __construct()
	 {
	 	  parent::__construct();
	 	  $data = SkrillPsp_Json::getQIWIJson();
	 	  $this->json 			= $this->decode($data, true);
	 	  $this->json['id'] 	= $this->setId();
	 	  $this->json['method'] = $this->method;
	 }
	 
}