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

class ValidationNoteJob {

    public function fire($job, $data = null) {
        foreach($data as $noteId){
            // recuperation de la note
            $note = NoteModel::find($noteId['id']);
            if($note and !$note->validated_at){
                $note->validated_at = now();
                $note->save();
            }
        }
        $job->delete();
    }
}
