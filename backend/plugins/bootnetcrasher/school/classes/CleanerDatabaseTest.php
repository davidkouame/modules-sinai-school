<?php

namespace Bootnetcrasher\School\Classes;

use BootnetCrasher\School\Models\NoteModel;
use BootnetCrasher\School\Models\MoyenneModel;
use BootnetCrasher\School\Models\NoteEleve;
use BootnetCrasher\School\Models\AnneeScolaireModel;
use BootnetCrasher\School\Models\ClasseMatiereModel;
use BootnetCrasher\School\Models\ClasseModel;

class CleanerDatabaseTest {

    public function fire($job, $data = null) {
        $this->deleEleveByNoteEleve();
        $this->deleteClasseMatiere();
        $this->deleteNote();
        $this->deleteMoyenne();
        $job->delete();
    }
    
    // delete eleve
    public function deleEleveByNoteEleve(){
        $elevesnotes = NoteEleve::all();
        $elevesnotes->each(function($elevenote, $key){
            if(!$elevenote->note || !$elevenote->eleve){
                $elevenote->delete();
            }
        });
    }

    // delete moyenne par by eleve
    public function deleteMoyenne(){
        $moyennes = MoyenneModel::all();
        foreach($moyennes as $moyenne){
            if(!$moyenne->eleve)
                $moyenne->delete();
        }
    }

    // clear fake matiere in bootnetcrasher_school_classe_matiere
    public function deleteClasseMatiere(){
        $classesmatieres = ClasseMatiereModel::all();
        foreach($classesmatieres as $classematiere){
            if(!$classematiere->matiere){
                $classematiere->delete();
            }
        }
    }

    // clear a fake note
    public function deleteNote(){
        $notes = NoteModel::all();
        $notes->each(function($note, $key){
            if(!$note->matiere)
                $note->delete();
        });
    }
    
}
