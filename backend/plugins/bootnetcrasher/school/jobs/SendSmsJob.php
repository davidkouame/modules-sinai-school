<?php

namespace Bootnetcrasher\School\Jobs;

use BootnetCrasher\School\Models\JobModel;
use BootnetCrasher\School\Models\JobSuccessModel;
use Illuminate\Support\Collection;
use DB;
require_once(__DIR__ . './../../sms/plugin/Sms4all-php/autoload.php');


class SendSmsJob{

    public function fire($job, $data = null) {
        try{
            $api_client = new \Sms4all\ApiClient();
            $sendsms_api = new \Sms4all\Api\SendsmsAPI($api_client);
            $sendsms_api->sendSms($data["code"], $data["message"], $data["sendername"], $data["sendertelname"]);
            $this->saveSuccessJob($job);
            trace_log("Sms envoyé ");
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
}