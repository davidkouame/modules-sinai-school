<?php

namespace Bootnetcrasher\School\Classes;

use BootnetCrasher\School\Models\LogSmsModel;

class Sms{
    
    // send sms
    public function send($tel, $parent, $eleve, $body){
        try{
            $this->logSms($tel, $parent, $eleve, $body);
        } catch (Exception $ex) {
           
        }
    }
    
    // log when we send sms
    public function logSms($tel, $parent, $eleve, $body){
        try{
            $logSms = new LogSmsModel;
            $logSms->tel = $tel;
            $logSms->parent_id = $parent->id;
            $logSms->eleve_id = $eleve->id;
            $logSms->content = $body;
            $logSms->save();
        } catch (Exception $ex) {

        }
    }
}