<?php

function compat_pbkdf2($algo, $password, $salt, $iterations, $length = 0, $rawOutput = false)
{
    // check for hashing algorithm
    if (!in_array(strtolower($algo), hash_algos())) {
        trigger_error(sprintf(
            '%s(): Unknown hashing algorithm: %s',
            __FUNCTION__, $algo
        ), E_USER_WARNING);
        return false;
    }

    // check for type of iterations and length
    foreach (array(4 => $iterations, 5 => $length) as $index => $value) {
        if (!is_numeric($value)) {
            trigger_error(sprintf(
                '%s() expects parameter %d to be long, %s given',
                __FUNCTION__, $index, gettype($value)
            ), E_USER_WARNING);
            return null;
        }
    }

    // check iterations
    $iterations = (int)$iterations;
    if ($iterations <= 0) {
        trigger_error(sprintf(
            '%s(): Iterations must be a positive integer: %d',
            __FUNCTION__, $iterations
        ), E_USER_WARNING);
        return false;
    }

    // check length
    $length = (int)$length;
    if ($length < 0) {
        trigger_error(sprintf(
            '%s(): Iterations must be greater than or equal to 0: %d',
            __FUNCTION__, $length
        ), E_USER_WARNING);
        return false;
    }

    // check salt
    if (strlen($salt) > PHP_INT_MAX - 4) {
        trigger_error(sprintf(
            '%s(): Supplied salt is too long, max of INT_MAX - 4 bytes: %d supplied',
            __FUNCTION__, strlen($salt)
        ), E_USER_WARNING);
        return false;
    }

    // initialize
    $derivedKey = '';
    $loops = 1;
    if ($length > 0) {
        $loops = (int)ceil($length / strlen(hash($algo, '', $rawOutput)));
    }

    // hash for each blocks
    for ($i = 1; $i <= $loops; $i++) {
        $digest = hash_hmac($algo, $salt . pack('N', $i), $password, true);
        $block = $digest;
        for ($j = 1; $j < $iterations; $j++) {
            $digest = hash_hmac($algo, $digest, $password, true);
            $block ^= $digest;
        }
        $derivedKey .= $block;
    }

    if (!$rawOutput) {
        $derivedKey = bin2hex($derivedKey);
    }

    if ($length > 0) {
        return substr($derivedKey, 0, $length);
    }

    return $derivedKey;
}

function crypt_data($password, $data) {
    // Set a random salt
    $salt = openssl_random_pseudo_bytes(8);
    // Set iv containung just zeros
    $iv  = "\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0";
    // Build the key using pbkdf2 with sha1
    $key = compat_pbkdf2("sha1", $password, $salt, 1, 256, true);

    $encrypted_data = openssl_encrypt($data, 'aes-256-cbc', $key, true, $iv);

    return urlencode(base64_encode($salt . $encrypted_data));
  }

  $array = array(
    "amount" => 1000,
    "merchant_id" => "3e40a821",
    "customer" => array(
      "firstname" => "John",
      "country" => "DE",
      "email" => "wpf@skrill.com",
      "ip" => ($_SERVER['REMOTE_ADDR'])
    ),
    "method" => "DB",
    "currency" => "USD",
    "theme"=>"skeuo",
    "descriptor" => "wpf test",
    "transaction_id" => "FOO",
    "channel_id" => "channelid_3d",
    "success_url" => "http://www.reactiongifs.com/wp-content/uploads/2013/07/oh-yes.gif",
    "error_url" => "http://www.reactiongifs.com/wp-content/uploads/2013/07/NO.gif"
  );
  
  
  echo "<br><br><b> the url is"."<a href=https://wpf.dev.skrillws.net/3e40a821/payments/new?payload=".crypt_data("B[zcj2AGQmL@3k", json_encode($array))."> here </b></a>";
?>