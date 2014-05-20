<?php
/**
 * Class for PaySafeCard CreateDisposition requestes
 * @package SkrillPsp
 *
 */
class SkrillPsp_PaySafeCardCreateDisposition extends SkrillPsp_PaySafeCardPA
{
	 
	/**
	 * Constructor
	 *
	 * Loads json request source and and decodes it in php array and sets id and 
	 * method parameters
	 *
	 * @return void
	 */
	 public function __construct()
	 {
	 	  parent::__construct();
	 	  $data = SkrillPsp_Json::getPaySafeCardCreateDispositionJson();
	 	  $this->json = $this->decode($data, true);
	 	  $this->json['id'] = $this->setId();
	 }
	 
	 /**
	  * Set local account parameter
	  * 
	  * @param string $locale
	  * @return object SkrillPsp_PaySafeCardCreateDisposition
	  */
	 public function setLocale($locale)
	 {
	 	  $this->json['params'][$this->account]['locale'] = $locale;
	 	  
	 	  return $this;
	 }
	 
	 /**
	  * Set account language parameter
	  * 
	  * @param string $lang
	  * @return object SkrillPsp_PaySafeCardCreateDisposition
	  */
	 public function setAccountLanguage($lang)
	 {
	 	   $this->json['params'][$this->account]['language'] = $lang;
	 	   
	 	   return $this;
	 }
	 
	 /**
	  * Set account minage parameter
	  * 
	  * @param mixed $age
	  * @return object SkrillPsp_PaySafeCardCreateDisposition
	  */
	 public function setMinAge($age)
	 {
	 	   $this->json['params'][$this->account]['minage'] = $age;
	 	   
	 	   return $this;
	 }
	 
	 /**
	  * Set account shopid parameter
	  * @param mixed $id
	  * @return object SkrillPsp_PaySafeCardCreateDisposition
	  */
	 public function setShopId($id)
	 {
	 	  $this->json['params'][$this->account]['shopid'] = $id;
	 	  
	 	  return $this;
	 }
	 
	 /**
	  * Set account shoplabel parameter
	  * 
	  * @param string $label
	  * @return object SkrillPsp_PaySafeCardCreateDisposition
	  */
	 public function setShopLabel($label)
	 {
	 	  $this->json['params'][$this->account]['shoplabel'] = $label;

	 	  return $this;
	 }
	 
	 /**
	  * Set account country parameter
	  * 
	  * @param string $country
	  * @return object SkrillPsp_PaySafeCardCreateDisposition
	  */
	 public function setAccountCountry($country)
	 {
	 	   $this->json['params'][$this->account]['country'] = $country;
	 	   
	 	   return $this;
	 }
	 
	 /**
	  * Overrides method from parent class that should not be used in this class
	  * @throws OutOfBoundsException
	  */
	 public function setCountryRestriction()
	 {
	 	   throw new OutOfBoundsException("Country restriction parameter is not availbale for PaySafeCard CreateDisposition");
	 }
}