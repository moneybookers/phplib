<?php 
$response = file_get_contents('php://input');
$response = str_replace('response=', '', $response);
$json = json_decode($response, true);


$fh = fopen("error.txt", 'a');
fwrite($fh, date('Y-m-d H:i:s') ."\n*********************\n");
fwrite($fh, print_r($_REQUEST,true));
fwrite($fh, "---------------------\n");
fwrite($fh, print_r($json,true));
fclose($fh);

echo "OK";
?>