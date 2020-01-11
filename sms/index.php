<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once(__DIR__ . '/Sms.php');

$sms = new Sms();
try{
    $response = $sms->send("22547886905", "Test ayauka");
    print_r($response);
}catch(\Exception $e){
    echo 'Caught exception: ', $e->getMessage(), "\n";
    echo 'Resepone Header: ', print_r($e->getResponseHeaders(), true), "\n";
    echo 'Resepone Body: ', $e->getResponseBody(), "\n"; 
}
