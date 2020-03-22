<?php

namespace Bootnetcrasher\School\Classes;

// require './../../guzzle/vendor/autoload.php';
require_once(__DIR__ . './../../sms/plugin/Sms4all-php/autoload.php');

use BootnetCrasher\School\Models\LogSmsModel;
use BootnetCrasher\School\Models\ParentModel;
use BootnetCrasher\School\Models\EleveModel;
use BootnetCrasher\School\Models\AbonnementModel;
use Bootnetcrasher\School\Jobs\SendSmsJob;
use BootnetCrasher\School\Models\ParametrageAppModel;
use Queue;

class Sms{

    private $sendername = "Ayauka";
    // private $code = "43WY45AM85";
    private $code = null;
    private $sendsms_api = null;
    private $indicateur = "225";
    private $isSendSms = false;

    public function __construct(){
        $api_client = new \Sms4all\ApiClient();
        $this->sendsms_api = new \Sms4all\Api\SendsmsApi($api_client);
        $parametrageApp = ParametrageAppModel::find(1);
        $this->code = $parametrageApp->code_login_sms4all;
        $this->isSendSms = $parametrageApp->send_sms_statut == 1 ? true : false;
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
            $this->sendWithoutLog($this->getIndicateur($parent).$tel, $body);
            $this->logSms($tel, $parent, $eleve, $body);
        } catch (Exception $ex) {
            trace_log("message : ".$ex->getMessage());
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
            if($this->isSendSms){
                Queue::push(SendSmsJob::class, 
                [
                    "code" => $this->code, 
                    "message" => $body, 
                    "sendername" => $this->sendername, 
                    "sendertelname" => $this->getIndicateur($parent).$tel
                ]);
            }
            $this->logSms($tel, $parent, $eleve, $body);
        } catch (Exception $ex) {
            trace_log("message : ".$ex->getMessage());
        }
    }

    /*
        Envoi des parametres de connexions aux parents
        @String $tel User tel
        @BootnetCrasher\School\Models\ParentModel $parent Parent user
        @String $body Message sms
    */
    public function sendParamsUserConnexionQueue(String $tel, String $body, Parentmodel $parent = null){
        try{
            if($this->isSendSms){
                Queue::push(SendSmsJob::class, 
                [
                    "code" => $this->code, 
                    "message" => $body, 
                    "sendername" => $this->sendername, 
                    "sendertelname" => $this->getIndicateur($parent).$tel
                ]);
            }
            $this->logSms($tel, $parent, null, $body);
        } catch (Exception $ex) {
            trace_log("message : ".$ex->getMessage());
        }
    }

    public function sendWithoutLog($tel, $message){
        try{
            if($this->isSendSms)
                $this->sendsms_api->sendSms($this->code, $message, $this->sendername, $tel);
            trace_log("sms envoyé ");
        }catch(\Exception $ex){
            trace_log("message : ".$ex->getMessage());
            trace_log("Sms non envoyé ");
        }
    }

    public function sendParent($parent, $eleve, $body){
        try{
            $this->logSmsParent(null, $parent, $eleve, $body);
        } catch (Exception $ex) {
            trace_log("message : ".$ex->getMessage());
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
            $this->sendWithoutLog($this->getIndicateur($parent).$parent->tel, $body);
            $this->logSms($parent->tel, $parent, null, $body, $abonnement);
        } catch (Exception $ex) {
            trace_log("message : ".$ex->getMessage());
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
            if($this->isSendSms){
                Queue::push(SendSmsJob::class, 
                [
                    "code" => $this->code, 
                    "message" => $body, 
                    "sendername" => $this->sendername, 
                    "sendertelname" => $this->getIndicateur($parent).$parent->tel
                ]);
            }
            $this->logSms($parent->tel, $parent, null, $body, $abonnement);
        } catch (Exception $ex) {
            trace_log("message : ".$ex->getMessage());
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
             trace_log("message : ".$ex->getMessage());
        }
    }

    public function getIndicateur($parent){
        return $parent->pays->indicatif;
        // trace_log(" pays ".json_encode($parent->pays));
        // return "225";
    }
}