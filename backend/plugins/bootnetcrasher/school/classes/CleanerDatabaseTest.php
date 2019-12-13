<?php

namespace Bootnetcrasher\School\Classes;

use BootnetCrasher\School\Models\NoteModel;
use BootnetCrasher\School\Models\NoteEleve;
use BootnetCrasher\School\Models\AnneeScolaireModel;
use BootnetCrasher\School\Models\ClasseModel;

class CleanerDatabaseTest {

    public function fire($job, $data = null) {
        $this->deleEleveByNoteEleve();
        $job->delete();
    }
    
    public function deleEleveByNoteEleve(){
        $elevesnotes = NoteEleve::all();
        $elevesnotes->each(function($elevenote, $key){
            if($elevenote->note || $elevenote->eleve){
                $elevenote->delete();
            }
        });
    }
    
}
