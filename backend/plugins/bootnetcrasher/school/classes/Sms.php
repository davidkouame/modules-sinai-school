<?php

namespace Bootnetcrasher\School\Classes;

use BootnetCrasher\School\Models\LogSmsModel;

class Sms{
    
    // send sms
    public function send($tel, $parent, $eleve, $body){
        try{
            $this->logSms($tel, $parent, $eleve, $body);
        } catch (Exception $ex) {
            trace_log("message : ".$ex->getMessage().", trace log".$ex->getTrace());
        }
    }

    public function sendParent($parent, $eleve, $body){
        try{
            $this->logSmsParent(null, $parent, $eleve, $body);
        } catch (Exception $ex) {
            trace_log("message : ".$ex->getMessage().", trace log".$ex->getTrace());
        }
    }

    public function sendParentForAbonnement($parent, $body, $abonnement){
        try{
            $this->logSms(null, $parent, null, $body, $abonnement);
        } catch (Exception $ex) {
             trace_log("message : ".$ex->getMessage().", trace log".$ex->getTrace());
        }
    }

    public function logSms($tel, $parent, $eleve, $body, $abonnement = null){
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