<?php
/**
 * HTTP Client for http request. 
 * Wraps php curl library
 * @link http://php.net/manual/en/book.curl.php
 * @package SkrillPsp
 */
class SkrillPsp_Http
{
	// Supported http verbs
	const PUT    = "PUT";
	const DELETE = "DELETE";
	const GET	 = "GET";
	const POST   = "POST";
	static private $post = "POST";
	
	// Json error messages code/value
	protected  static $messages = array(
			JSON_ERROR_NONE  => 'No error has occured',
			JSON_ERROR_DEPTH => 'The maximum stack depth has been exceeded',
			JSON_ERROR_STATE_MISMATCH => 'Invalid or malformed JSON',
			JSON_ERROR_CTRL_CHAR => 'Control character error, possibly incorrectly encoded',
			JSON_ERROR_SYNTAX => 'Syntax error in json',
			JSON_ERROR_UTF8 => 'Malformed UTF-8 characters, possibly incorrectly encoded'
	);
	
	/**
	 * Wrapper of the php decode_json function.
	 * Takes a JSON encoded string and converts it into a PHP variable.
	 *
	 * @param string $json
	 * @param bool $assoc Optional return stdClass if false and array if true
	 * @throws RuntimeException
	 * @return mixed Returns the value encoded in json in appropriate PHP type
	 */
	private static function decode($json, $assoc = false)
	{
		$result = json_decode($json, $assoc);
		 
		if($result) {
			return $result;
		}
		 
		throw new RuntimeException(self::$messages[json_last_error()]);  
	}
 	/**
 	 * Executes delete request
 	 * @param string $url 
 	 * @return bool
 	 */
	public static function delete($url)
	{
		$response = self::_doUrlRequest(self::DELETE, $url);
		if($response['status'] === 200) {
			return true;
		}
		else {
			 SkrillPsp_Util::statusCodeException($response['status']);
		}
	}
	
	/**
	 * Executes get request
	 * @param string $url
	 * @return $response
	 */
	public static function get($url)
	{
		 $response = self::_doUrlRequest(self::GET, $url);
		 if($response['status'] === 200) {
		 	 return $response;
		 }
		 else {
		 	 SkrillPsp_Util::statusCodeException($response['status']);
		 }
	}
	
	/**
	 * Executes put request
	 * @param string $url
	 * @param array|null $params
	 */
	public static function put($url, $params = null)
	{
		$response = self::_doUrlRequest(self::PUT, $url, $params);
		$responseCode = $response['status'];
		if($responseCode === 200 || $responseCode === 201) {
			return $response['body'];
		}
		else {
			SkrillPsp_Util::statusCodeException($responseCode);
		}
	}	
	
	/**
	 * Executes POST request
	 * @see self::verifyResponse()
	 * @param string $url 
	 * @param array $params
	 * @return SkrillPsp_Response_Success|SkrillPsp_Response_Error 
	 * @throws SkrillPsp_Exception
	 */
	 public static function post($url, $params = null)
	 {
	 	 $response = self::_doUrlRequest(self::$post, $url, $params);
	 	 $responseCode = $response['status'];
	 	 if($responseCode === 200 || $responseCode === 201) {
	 	 	// return $response['body'];
	 	     return self::verifyResponse($response['body']);
	 	 }
	 	 else {
	 	 	  SkrillPsp_Util::statusCodeException($responseCode);
	 	 }
	 }
	 
	
	/**
	 * Makes HTTP request
	 * 
	 * @param string $httpVerb
	 * @param string $url
	 * @param null|array $requestBody
	 * @return array Returns results from http request as an associative array
	 */
	private static function _doUrlRequest($httpVerb, $url, $requestBody = null)
	{
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $httpVerb);
		// For debug only (SSL)
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
		
		curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                    'Accept: application/json',
		    'Content-type: application/json',
		    'Content-Length: ' . strlen($requestBody)
		));
		
		if(!empty($requestBody)) {
			curl_setopt($curl, CURLOPT_POSTFIELDS, $requestBody);
		}
		
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($curl);

                
		if(curl_errno($curl))
		{
			throw new SkrillPsp_Exception(curl_error( $curl), curl_errno($curl));
		}
		$httpStatus = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		curl_close($curl);
		
		return array('status' => $httpStatus, 'body' => $response);  
			
	}
	
	/**
	 * This method acts like simple factory for responses objects
	 * 
	 * @param string $responseJson
	 * @return object SkrillPsp_Response_Success|SkrillPsp_Response_Error|SkrillPsp_Response_ErrorLevel
	 */
	private static function verifyResponse($responseJson)
	{
		$response = self::decode($responseJson);
	     if(isset($response->result)) {
	     	 if($response->result->level == 0) {
		 	     return new SkrillPsp_Response_Success($response);
	     	 }
	     	 else {
	     	 	  return new SkrillPsp_Response_ErrorLevel($response);
	     	 }
		 }
		 
		 else if(isset($response->error)) {
		 	 return new SkrillPsp_Response_Error($response);
		 }  
	} 
}
?>
