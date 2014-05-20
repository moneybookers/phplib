<?php
require_once('lib/SkrillPSP.php');

$obj = new SkrillPsp_Qiwi();
$result = $obj->createInvoice(array('identification' => array('transactionid' => '3434', 'referenceid' => '56565'),
                                    'payment' => array('amount' => '', 'currency' => 'RUB', 'descriptor' => 'comment', 'lifetime' => '18')));

