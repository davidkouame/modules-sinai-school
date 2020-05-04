<?php

namespace Bootnetcrasher\School\Jobs;

use BootnetCrasher\School\Models\JobModel;
use BootnetCrasher\School\Models\JobSuccessModel;
use Illuminate\Support\Collection;
use BootnetCrasher\School\Models\AbonnementModel;
use DB;
use BootnetCrasher\School\Models\ParametrageAppModel;

require_once(__DIR__ . './../../sms/plugin/Sms4all-php/autoload.php');


class SendSmsJob{

    public function fire($job, $data = null) {
        try{
            if(isset($data['typeUser']) && $data['typeUser'] == "professeur"){
                $schoolId = $data['schoolId'];
                if($this->isModuleSmsAppEnable() && $this->isModuleSmsEcoleEnable($abonnement) 
                && $this->isModuleSmsAbonnementEnable($data['schoolId'])){
                    $api_client = new \Sms4all\ApiClient();
                    $sendsms_api = new \Sms4all\Api\SendsmsAPI($api_client);
                    $sendsms_api->sendSms($data["code"], $data["message"], $data["sendername"], $data["sendertelname"]);
                    $this->saveSuccessJob($job);
                    $this->reduceSmsModuleEcole($schoolId);
                    // $this->reduceSmsModuleAbonnement($abonnement);
                    trace_log("Sms envoyé ");
                }
            }else{
                $abonnement = AbonnementModel::find($data["abonnementId"]);
                if($abonnement && $this->isModuleSmsAppEnable() && $this->isModuleSmsEcoleEnable($abonnement->school_id) 
                && $this->isModuleSmsAbonnementEnable($abonnement)){
                    $api_client = new \Sms4all\ApiClient();
                    $sendsms_api = new \Sms4all\Api\SendsmsAPI($api_client);
                    $sendsms_api->sendSms($data["code"], $data["message"], $data["sendername"], $data["sendertelname"]);
                    $this->saveSuccessJob($job);
                    $this->reduceSmsModuleEcole($abonnement->school_id);
                    $this->reduceSmsModuleAbonnement($abonnement);
                    trace_log("Sms envoyé ");
                }else{
                    trace_log("Sms non envoyé ");
                }
            }
            
        }catch(\Exception $e){
            trace_log("sms non envoyé ");
            trace_log($e);
        }
        $job->delete();
    }

    // save success job
    public function saveSuccessJob($jobP){
        $job = JobModel::find($jobP->getJobId());
        if($job){
            $jobSuccess = new JobSuccessModel;
            $jobSuccess->queue = $job->queue;
            $jobSuccess->payload = $job->payload;
            $jobSuccess->attempts = $job->attempts;
            $jobSuccess->reserved_at = $job->reserved_at;
            $jobSuccess->available_at = $job->available_at;
            $jobSuccess->created_at = $job->created_at;
            $jobSuccess->created_date_at = now();
            $jobSuccess->save();
        }
    }

    // Permet de vérifier si le module SMS est actif pour toute l'application 
    public function isModuleSmsAppEnable(){
        $parametrageApp = ParametrageAppModel::find(1);
        return $parametrageApp->send_sms_statut == 1 ? true : false;
    }

    // Permet de vérifier si le module sms pour une école est actif et il existe encore des sms
    public function isModuleSmsEcoleEnable($schoolId){
        $abonnement = SmsSchoolModel::where('school_id', $schoolId)->first();
        return $smsschool && $smsschool->is_run == 1 && $smsschool->nbre_sms_restant > 0 ? true : false;
    }

    // Permet de vérifier si le module sms est actif et il existe des sms pour cet abonnement
    public function isModuleSmsAbonnementEnable(AbonnementModel $abonnement){
        return $abonnement && $abonnement->is_run == 1 && $smsschool->nbre_sms_restant > 0 ? true : false;
    }

    // Pour reduire le nombre de sms dans le module des sms de l'école
    public function reduceSmsModuleEcole($schoolId){
        $smsschool = SmsSchoolModel::where('school_id', $schoolId)->first();
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