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
use Queue;

class ValidationSectionJob {

    public function fire($job, $data = null) {
        foreach($data as $sectionId){
            $this->validationMoyene($sectionId);
            $this->validationAbsence($sectionId);
            $this->validationNote($sectionId);
        }
        $job->delete();
    }

    public function validationMoyene($sectionId){
        $moyennes = MoyenneModel::where('section_annee_scolaire_id', $sectionId)
            ->whereNull('validated_at')->select('id')->get();
        $moyennes = $moyennes ? $moyennes->toArray() : null;
        if($moyennes)
            Queue::push(ValidationMoyenneJob::class, $moyennes);
    }

    public function validationAbsence($sectionId){
        $absences = AbsenceEleveModel::where('section_annee_scolaire_id', $sectionId)
            ->whereNull('validated_at')->select('id')->get();
        $absences = $absences ? $absences->toArray() : null;
        if($absences)
            Queue::push(ValidationAbsenceJob::class, $absences);
    }

    public function validationNote($sectionId){
        $notes = NoteModel::where('section_annee_scolaire_id', $sectionId)
            ->whereNull('validated_at')->select('id')->get();
        $notes = $notes ? $notes->toArray() : null;
        if($notes)
            Queue::push(ValidationNoteJob::class, $notes);
    }
}
