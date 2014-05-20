<?php
$response = file_get_contents('php://input');
$response = str_replace('response=', '', $response);
$json = json_decode($response, true);

$fh = fopen("test_onetab.txt", 'a');
fwrite($fh, date('Y-m-d H:i:s') ."\n*********************\n");

fwrite($fh, "---------------------\n");
fwrite($fh, print_r($response, true));
fclose($fh); 

echo "OK";