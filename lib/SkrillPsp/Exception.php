<?php
/**
 * SkillPsp Exception class
 * @package SkrillPsp
 */
 class SkrillPsp_Exception extends Exception
 {
 	 public function __construct($message = "", $code = 0)
 	 {
 	 	  parent::__construct($message, $code);
 	 }
 }
?>
