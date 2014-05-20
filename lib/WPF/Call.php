<?php
/**
 * Class for WPF requests
 * 
 * @package WPF
 * @category Library
 *
 */
class WPF_Call
{
	 private $result; 
	 private $wpfEndPont;
	 
	 /**
	  * Set WPF endpoint
	  * @param string $url
	  */
	 public function setUri($url)
	 {
	 	   $this->wpfEndPoint = $url;
	 }
	 
	 /**
	  * Data encryption function
	  * 
	  * @param string $password
	  * @param string $data
	  * @return string 
	  */
	 private function crypt_data($password, $data) 
	 {
    	// Set a random salt
        $salt = openssl_random_pseudo_bytes(8);
        // Set iv containung just zeros
        $iv  = "\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0";
        // Build the key using pbkdf2 with sha1
        $key = $this->compat_pbkdf2("sha1", $password, $salt, 1, 256, true);

        $encrypted_data = openssl_encrypt($data, 'aes-256-cbc', $key, true, $iv);

        $this->result = urlencode(base64_encode($salt . $encrypted_data));
    }
    
    /**
     * Generate a PBKDF2 key derivation of a supplied password
     *
     * This is a hash_pbkdf2() implementation for PHP versions 5.3 and 5.4.
     * @link http://www.php.net/manual/en/function.hash-pbkdf2.php
     *
     * @param string $algo
     * @param string $password
     * @param string $salt
     * @param int $iterations
     * @param int $length
     * @param bool $rawOutput
     *
     * @return string
     */
	private function compat_pbkdf2($algo, $password, $salt, $iterations, $length = 0, $rawOutput = false) 
	{
		// check for hashing algorithm
		if (! in_array ( strtolower ( $algo ), hash_algos () )) {
			throw new SkrillPsp_Exception(sprintf ( '%s(): Unknown hashing algorithm: %s', __FUNCTION__, $algo)); 
		}
		
		// check for type of iterations and length
		foreach (  array (
				4 => $iterations,
				5 => $length 
		) as $index => $value ) {
			if (! is_numeric ( $value )) {
				throw new SkrillPsp_Exception(sprintf ( '%s() expects parameter %d to be long, %s given', __FUNCTION__, $index, gettype ( $value ) ));
			}
		}
		
		// check iterations
		$iterations = ( int ) $iterations;
		if ($iterations <= 0) {
			   throw new SkrillPsp_Exception(sprintf ( '%s(): Iterations must be a positive integer: %d', __FUNCTION__, $iterations ));
		}
		
		// check length
		$length = ( int ) $length;
		if ($length < 0) {
			throw new SkrillPsp_Exception(sprintf ( '%s(): Iterations must be greater than or equal to 0: %d', __FUNCTION__, $length ));
		}
		
		// check salt
		if (strlen ( $salt ) > PHP_INT_MAX - 4) {
			throw new SkrillPsp_Exception(sprintf ( '%s(): Supplied salt is too long, max of INT_MAX - 4 bytes: %d supplied', __FUNCTION__, strlen ( $salt ) ));
		}
		
		// initialize
		$derivedKey = '';
		$loops = 1;
		if ($length > 0) {
			$loops = ( int ) ceil ( $length / strlen ( hash ( $algo, '', $rawOutput ) ) );
		}
		
		// hash for each blocks
		for($i = 1; $i <= $loops; $i ++) {
			$digest = hash_hmac ( $algo, $salt . pack ( 'N', $i ), $password, true );
			$block = $digest;
			for($j = 1; $j < $iterations; $j ++) {
				$digest = hash_hmac ( $algo, $digest, $password, true );
				$block ^= $digest;
			}
			$derivedKey .= $block;
		}
		
		if (! $rawOutput) {
			$derivedKey = bin2hex ( $derivedKey );
		}
		
		if ($length > 0) {
			return substr ( $derivedKey, 0, $length );
		}
		
		return $derivedKey;
	}
	
	/**
	 * Parameters that need to be sent to WPF
	 * 
	 * @param string $password
	 * @param array $params
	 */
	public function setParameters($password, array $params)
	{
		  $json = json_encode($params);
		  $this->crypt_data($password, $json);
	}
	
	/**
	 * Return wpf endpoint with provided parameters appended to it
	 * 
	 * @return string
	 */
	public function getResult()
	{
		return $this->wpfEndPoint . "=" . $this->result;
	}
	
}