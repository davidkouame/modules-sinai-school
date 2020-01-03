<?php

namespace Bootnetcrasher\School\Jobs;

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
use Queue;

class ValidationAnneeScolaireJob {

    public function fire($job, $data = null) {
        foreach($data as $anneeId){
            // recuperation de toutes les sections qui appartiennent a cette année scolaire
            $sections = SectionAnneeScolaireModel::where('annee_scolaire_id', $anneeId)
                ->select('id')->get();
            $sections = $sections ? $sections->toArray() : null;
            if($sections)
                Queue::push(ValidationSectionJob::class, $sections);
        }
        $job->delete();
    }
}
