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
use BootnetCrasher\School\Models\SmsSchoolModel;
use BootnetCrasher\School\Models\AbonnementEleveModel;
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
    public function send(String $tel, String $body, Parentmodel $parent = null, 
    EleveModel $eleve = null, Abonnement $abonnement){
        try{
            $this->sendWithoutLog($this->getIndicateur($parent).$tel, $body, $abonnement);
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
    public function sendQueue(String $tel, String $body, Parentmodel $parent = null, 
    EleveModel $eleve = null, AbonnementModel $abonnement){
        try{
            if($this->isSendSms){
                Queue::push(SendSmsJob::class, 
                [
                    "code" => $this->code, 
                    "message" => $body, 
                    "sendername" => $this->sendername, 
                    "sendertelname" => $this->getIndicateur($parent).$tel,
                    "abonnementId" => $abonnement->id
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
    public function sendParamsUserConnexionQueue(String $tel, String $body, Parentmodel $parent = null, 
    AbonnementModel $abonnement){
        try{
            if($this->isSendSms){
                Queue::push(SendSmsJob::class, 
                [
                    "code" => $this->code, 
                    "message" => $body, 
                    "sendername" => $this->sendername, 
                    "sendertelname" => $this->getIndicateur($parent).$tel,
                    "abonnementId" => $abonnement->id
                ]);
            }
            $this->logSms($tel, $parent, null, $body);
        } catch (Exception $ex) {
            trace_log("message : ".$ex->getMessage());
        }
    }

    public function sendWithoutLog($tel, $message, $abonnement){
        try{
            if($this->isModuleSmsAppEnable() && $this->isModuleSmsEcoleEnable($abonnement) && $this->isModuleSmsAbonnementEnable($abonnement)){
                $this->sendsms_api->sendSms($this->code, $message, $this->sendername, $tel);
                $this->reduceSmsModuleEcole($abonnement);
                $this->reduceSmsModuleAbonnement($abonnement);
                trace_log("sms envoyé ");
            }
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
            $this->sendWithoutLog($this->getIndicateur($parent).$parent->tel, $body, $abonnement);
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
                    "sendertelname" => $this->getIndicateur($parent).$parent->tel,
                    "abonnementId" => $abonnement->id
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

    // Permet de vérifier si le module SMS est actif pour toute l'application 
    public function isModuleSmsAppEnable(){
        return $this->isSendSms;
    }

    // Permet de vérifier si le module sms pour une école est actif et il existe encore des sms
    public function isModuleSmsEcoleEnable(AbonnementModel $abonnement){
        $smsschool = SmsSchoolModel::where('school_id', $abonnement->school_id)->first();
        return $smsschool && $smsschool->is_run == 1 && $smsschool->nbre_sms_restant > 0 ? true : false;
    }

    // Permet de vérifier si le module sms est actif et il existe des sms pour cet abonnement
    public function isModuleSmsAbonnementEnable(AbonnementModel $abonnement){
        return $abonnement && $abonnement->is_run == 1 && $smsschool->nbre_sms_restant > 0 ? true : false;
    }

    // Pour reduire le nombre de sms dans le module des sms de l'école
    public function reduceSmsModuleEcole(AbonnementModel $abonnement){
        $smsschool = SmsSchoolModel::where('school_id', $abonnement->school_id)->first();
        $smsschool->nbre_sms_restant = $smsschool->nbre_sms_restant - 1;
        $smsschool->nbre_sms_consome = $smsschool->nbre_sms_consome + 1;
        $smsschool->save();
    }

    // Pour reduire le nombre de sms dans le module des sms au niveau de l'abonnement
    public function reduceSmsModuleAbonnement(AbonnementModel $abonnement){
        $abonnement->nbre_sms_restant = $smsschool->nbre_sms_restant - 1;
        $abonnement->nbre_sms_consome = $smsschool->nbre_sms_consome + 1;
        $abonnement->save();
    }
}