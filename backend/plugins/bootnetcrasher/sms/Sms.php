
<?php

require_once(__DIR__ . '/plugin/Sms4all-php/autoload.php');

class Sms{
    private $sendername = "Ayauka";
    private $code = "43WY45AM85";
    private $sendsms_api = null;

    public function __construct(){
        $api_client = new Sms4all\ApiClient();
        $this->sendsms_api = new Sms4all\Api\SendsmsAPI($api_client);
    }

    public function send($tel, $message){
        try{
            return $this->sendsms_api->sendSms($this->code, $message, $this->sendername, $tel);
        }catch(\Exception $e){
            throw new Exception($e);
        }
    }
}

?>