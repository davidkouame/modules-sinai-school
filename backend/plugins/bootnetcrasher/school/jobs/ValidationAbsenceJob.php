<?php

namespace Bootnetcrasher\School\Jobs;

use BootnetCrasher\School\Models\AbsenceEleveModel;
use Mail;
use Event;

class ValidationAbsenceJob {

    public function fire($job, $data = null) {
        foreach($data as $absenceId){
            // recuperation de l'absence
            $absence = AbsenceEleveModel::find($absenceId['id']);
            if($absence and !$absence->validated_at){
                $absence->validated_at = now();
                $absence->save();
            }
        }
        $job->delete();
    }
}
