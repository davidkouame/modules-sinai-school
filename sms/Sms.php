<?php
/*require_once(__DIR__ . '/plugin/clicksend/vendor/autoload.php');

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
}*/
?>

<?php
// this file contains testings of all functions for Sms4all

require_once(__DIR__ . '/plugin/Sms4all-php/autoload.php');
// uncomment below to set timezone ref: http://php.net/manual/en/timezones.php
//date_default_timezone_set('America/New_York');

// uncomment below to enable debugging
// Sms4all\Configuration::getDefaultConfiguration()->setDebug(TRUE);


class Sms4allTest {
    function testGetSmsAvailabilitySmsavailability() {
        // initialize the API client with default base URL: http://sms4all.org:3030/apis
        $api_client = new Sms4all\ApiClient();

        $code = "DEMO";  // code

        try {
            $smsavailability_api = new Sms4all\Api\SmsavailabilityAPI($api_client);
            // return <a href="#model_SmsAvailability">SmsAvailability (model)</a>
            $response = $smsavailability_api->getSmsAvailability($code);
            print_r($response);
        } catch (Sms4all\ApiException $e) {
            echo 'Caught exception: ', $e->getMessage(), "\n";
            echo 'Resepone Header: ', print_r($e->getResponseHeaders(), true), "\n";
            echo 'Resepone Body: ', $e->getResponseBody(), "\n";
        }
    }

    function testSendSmsSendsms() {
        // initialize the API client with default base URL: http://sms4all.org:3030/apis
        $api_client = new Sms4all\ApiClient();

        $code = "sampleCode";  // code
        $message = "150 characters / page";  // message
        $sendername = "11 characters max";  // sendername
        $mobilenumber = "example : 22551080990";  // mobilenumber

        try {
            $sendsms_api = new Sms4all\Api\SendsmsAPI($api_client);
            // return <a href="#model_SendSms">SendSms (model)</a>
            $response = $sendsms_api->sendSms($code, $message, $sendername, $mobilenumber);
            print_r($response);
        } catch (Sms4all\ApiException $e) {
            echo 'Caught exception: ', $e->getMessage(), "\n";
            echo 'Resepone Header: ', print_r($e->getResponseHeaders(), true), "\n";
            echo 'Resepone Body: ', $e->getResponseBody(), "\n";
        }
    }

    function testSmsReportSmsreport() {
        // initialize the API client with default base URL: http://sms4all.org:3030/apis
        $api_client = new Sms4all\ApiClient();

        $code = "sampleCode";  // code
        $msgid = "sampleMsgid";  // msgid

        try {
            $smsreport_api = new Sms4all\Api\SmsreportAPI($api_client);
            // return <a href="#model_SmsReport">SmsReport (model)</a>
            $response = $smsreport_api->smsReport($code, $msgid);
            print_r($response);
        } catch (Sms4all\ApiException $e) {
            echo 'Caught exception: ', $e->getMessage(), "\n";
            echo 'Resepone Header: ', print_r($e->getResponseHeaders(), true), "\n";
            echo 'Resepone Body: ', $e->getResponseBody(), "\n";
        }
    }

    function runAllTests() {
        /* Resource: Smsavailability */

        echo 'Calling endpoint: getSmsAvailability ... ';
        $this->testGetSmsAvailabilitySmsavailability();
        echo "\n";
        sleep(1);

        /* Resource: Sendsms */

        // echo 'Calling endpoint: sendSms ... ';
        //$this->testSendSmsSendsms();
        echo "\n";
        sleep(1);

        /* Resource: Smsreport */

        // echo 'Calling endpoint: smsReport ... ';
        //$this->testSmsReportSmsreport();
        echo "\n";
        sleep(1);
    }
}

$sms4allTest = new Sms4allTest();
$sms4allTest->runAllTests();

?>
