<?php
require_once(__DIR__ . '/plugin/clicksend/vendor/autoload.php');

// Configure HTTP basic authorization: BasicAuth
$config = ClickSend\Configuration::getDefaultConfiguration()
    ->setUsername('bootnetcrasher@gmail.com')
    ->setPassword('6DB69250-5E66-F91A-08DC-E231B42EE754');

// $apiInstance = new ClickSend\Api\AccountApi(new GuzzleHttp\Client(),$config);

$apiInstance = new ClickSend\Api\AccountApi(new GuzzleHttp\Client(),$config);
$account = new \ClickSend\Model\Account(); // \ClickSend\Model\Account | Account model
$account->setUserName("johndoe");
$account->setPassword("pass");
$account->setUserPhone("47886905");
$account->setUserEmail("boo");
$account->setUserFirstName("John");
$account->setUserLastName("Doe");
$account->setAccountName("The Awesome Company");
$account->setCountry("CI");

try {
    $result = $apiInstance->accountGet();
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling AccountApi->accountGet: ', $e->getMessage(), PHP_EOL;
}
?>
