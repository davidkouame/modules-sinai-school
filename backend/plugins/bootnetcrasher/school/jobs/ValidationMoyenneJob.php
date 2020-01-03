<?php

namespace Bootnetcrasher\School\Jobs;

use BootnetCrasher\School\Models\AbsenceEleveModel;
use Mail;
use Event;
use Backend;
use BootnetCrasher\School\Models\NoteModel;
use BootnetCrasher\School\Models\EleveModel;
use BootnetCrasher\School\Models\MatiereModel;
use BootnetCrasher\School\Models\NoteEleve;
use BootnetCrasher\School\Models\MoyenneModel;
use BootnetCrasher\School\Models\ClasseEleveModel;
use BootnetCrasher\School\Models\ClasseMatiereModel;
use BootnetCrasher\School\Models\AnneeScolaireModel;
use BootnetCrasher\School\Models\SectionAnneeScolaireModel;

class ValidationMoyenneJob {

    public function fire($job, $data = null) {
        foreach($data as $moyenneId){
            $moyenne = MoyenneModel::find($moyenneId['id']);
            if($moyenne and !$moyenne->validated_at){
                $moyenne->validated_at = now();
                $moyenne->save();
            }
        }
        $job->delete();
    }
}
