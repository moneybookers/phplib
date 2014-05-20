<?php
/**
 * Class for QIWI Refund Status Track requests 
 * @author nikolayiliev
 *
 */
 class SkrillPsp_QIWIRefundStatusTrack extends SkrillPsp_QIWICancelInvoice
 {
 	   private $method = 'refundSatustrack';
 	   
 	   /**
 	    * Constructor
 	    *
 	    * Decodes json source in php array and sets id and method members of json request
 	    * @return void
 	    */
 	   public function __construct()
 	   {
 	   	    parent::__construct();
 	   	    $data = SkrillPsp_Json::getQIWIJson();
 	   	    $this->json = $this->decode($data, true);
 	   	    $this->json['id'] = $this->setId();
 	   	    $this->json['method'] = $this->method;
 	   }
 	   
 }