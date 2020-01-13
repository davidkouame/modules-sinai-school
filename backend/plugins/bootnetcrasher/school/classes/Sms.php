<?php

namespace Bootnetcrasher\School\Classes;

// require './../../guzzle/vendor/autoload.php';
require_once(__DIR__ . './../../sms/plugin/Sms4all-php/autoload.php');

use BootnetCrasher\School\Models\LogSmsModel;
use BootnetCrasher\School\Models\ParentModel;
use BootnetCrasher\School\Models\EleveModel;
use BootnetCrasher\School\Models\AbonnementModel;
use Bootnetcrasher\School\Jobs\SendSmsJob;
use Queue;

class Sms{

    private $sendername = "Ayauka";
    // private $code = "43WY45AM85";
    private $code = "43WY45AM85ddd";
    private $sendsms_api = null;
    private $indicateur = "225";

    public function __construct(){
        $api_client = new \Sms4all\ApiClient();
        $this->sendsms_api = new \Sms4all\Api\SendsmsAPI($api_client);
    }
    
    /*
        Save log when we send sms
        @String $tel User tel
        @BootnetCrasher\School\Models\ParentModel $parent Parent user
        @BootnetCrasher\School\Models\EleveModel $eleve User
        @String $body Message sms
    */
    public function send(String $tel, String $body, Parentmodel $parent = null, EleveModel $eleve = null){
        try{
            $this->sendWithoutLog($this->indicateur.$tel, $body);
            $this->logSms($tel, $parent, $eleve, $body);
        } catch (Exception $ex) {
            trace_log("message : ".$ex->getMessage().", trace log".$ex->getTrace());
        }
    }

    /*
        Send sms at parent by queue
        @String $tel User tel
        @BootnetCrasher\School\Models\ParentModel $parent Parent user
        @BootnetCrasher\School\Models\EleveModel $eleve User
        @String $body Message sms
    */
    public function sendQueue(String $tel, String $body, Parentmodel $parent = null, EleveModel $eleve = null){
        try{
            Queue::push(SendSmsJob::class, 
            [
                "code" => $this->code, 
                "message" => $body, 
                "sendername" => $this->sendername, 
                "sendertelname" => $this->indicateur.$tel
            ]);
            $this->logSms($tel, $parent, null, $body);
        } catch (Exception $ex) {
             trace_log("message : ".$ex->getMessage().", trace log".$ex->getTrace());
        }
    }

    public function sendWithoutLog($tel, $message){
        try{
            $this->sendsms_api->sendSms($this->code, $message, $this->sendername, $tel);
            trace_log("sms envoyé ");
        }catch(\Exception $e){
            trace_log("message : ".$ex->getMessage().", trace log".$ex->getTrace());
            trace_log("Sms non envoyé ");
        }
    }

    public function sendParent($parent, $eleve, $body){
        try{
            $this->logSmsParent(null, $parent, $eleve, $body);
        } catch (Exception $ex) {
            trace_log("message : ".$ex->getMessage().", trace log".$ex->getTrace());
        }
    }

    /*
        Send sms at parents when they save abonnement
        @String $tel User tel
        @BootnetCrasher\School\Models\ParentModel $parent Parent user
        @BootnetCrasher\School\Models\AbonnementModel $abonnement Abonnement user
        @String $body Message sms
    */
    public function sendParentForAbonnement($parent, $body, $abonnement){
        try{
            $this->sendWithoutLog($this->indicateur.$parent->tel, $body);
            $this->logSms($parent->tel, $parent, null, $body, $abonnement);
        } catch (Exception $ex) {
             trace_log("message : ".$ex->getMessage().", trace log".$ex->getTrace());
        }
    }

    /*
        Send sms at parents by queue when they save abonnement
        @String $tel User tel
        @BootnetCrasher\School\Models\ParentModel $parent Parent user
        @BootnetCrasher\School\Models\AbonnementModel $abonnement Abonnement user
        @String $body Message sms
    */
    public function sendParentForAbonnementQueue($parent, $body, $abonnement){
        try{
            Queue::push(SendSmsJob::class, 
            [
                "code" => $this->code, 
                "message" => $body, 
                "sendername" => $this->sendername, 
                "sendertelname" => $this->indicateur.$parent->tel
            ]);
            $this->logSms($parent->tel, $parent, null, $body, $abonnement);
        } catch (Exception $ex) {
             trace_log("message : ".$ex->getMessage().", trace log".$ex->getTrace());
        }
    }

    /*
        Save log when we send sms
        @String $tel User tel
        @BootnetCrasher\School\Models\ParentModel $parent Parent user
        @BootnetCrasher\School\Models\EleveModel $eleve User
        @BootnetCrasher\School\Models\AbonnementModel $abonnement Abonnement user
        @String $body Message sms
    */
    public function logSms(String $tel, Parentmodel $parent, EleveModel $eleve = null, String $body, AbonnementModel $abonnement = null){
        try{
            $logSms = new LogSmsModel;
            $logSms->tel = $tel;
            $logSms->parent_id = $parent->id;
            if($eleve)
                $logSms->eleve_id = $eleve->id;
            $logSms->content = $body;
            if($abonnement)
                $logSms->abonnement_id = $abonnement->id;
            $logSms->save();
        } catch (Exception $ex) {
             trace_log("message : ".$ex->getMessage().", trace log".$ex->getTrace());
        }
    }
}