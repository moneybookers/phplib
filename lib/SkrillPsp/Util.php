<?php
/**
 * Helper class for utility methods
 * @package SkrillPsp
 */
 class SkrillPsp_Util
 {
 	  private static $messageAuthentication = 'Request requires user authentication';
 	  private static $messageAuthorization  = 'Server understood the request, but is refusing to fulfil it';
 	  private static $messageNotFound 	 	= 'Requested resource could not be found';
 	  private static $messageUpgrade  	 	= 'Library needs to be upgraded';
 	  private static $messageServerError 	= 'Internal server error';
 	  private static $messsageServerDown 	= 'The server is currently unavailable...probably for overloaded or down for maintanence';
 	  
 	  public static function statusCodeException($statusCode)
 	  {
 	  	    switch($statusCode)
 	  	    {
 	  	    	 case 401:
 	  	    	    throw new SkrillPsp_Exception_Authentication(self::$messageAuthentication ,$statusCode);
 	  	    	    break;
 	  	    	 
 	  	    	 case 403:
 	  	    	    throw new SkrillPsp_Exception_Authorization(self::$messageAuthorization, $statusCode);
 	  	    	    break;
 	  	    	    
 	  	    	 case 404:
 	  	    	    throw new SkrillPsp_Exception_NotFound(self::$messageNotFound, $statusCode);
 	  	    	    break;
 	  	    	    
 	  	    	 case 426:
 	  	    	    throw new SkrillPsp_Exception_UpgradeRequired(self::$messageUpgrade, $statusCode);
 	  	    	    break;
 	  	    	   
 	  	    	case 500:
 	  	    	    throw new SkrillPsp_Exception_ServerError(self::$messageServerError, $statusCode);
 	  	    	    break;
 	  	    	    
 	  	        case 503:
 	  	            throw new SkillPsp_Exception_DownForMaintenance(self::$messageNotFound, $statusCode);
 	  	            break;
 	  	            
 	  	        default:
 	  	            throw new SkrillPsp_Exception_Unexpected('Unexpected HTTP RESPONSE # ' . $statusCode);
 	  	            break; 
 	  	    }
 	  }
 	  
 	  public static function isAssocArray($array)
 	  {
 	  		return (bool)count(array_filter(array_keys($array), 'is_string'));
 	  }
	  
 }
?>
