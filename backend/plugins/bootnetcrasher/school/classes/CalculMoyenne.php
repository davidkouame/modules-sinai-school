<?php

namespace Bootnetcrasher\School\Classes;

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

class CalculMoyenne {

    public function fire($job, $data = null) {
        $notes = NoteModel::all();
        foreach ($notes as $note) {
            // recuperation de la va
        }

        // recuperation de tous les élèves
        $eleves = EleveModel::all();
        foreach ($eleves as $eleve) {
            $classeEleve = ClasseEleveModel::where('eleve_id', $eleve->id)
                    ->first();
            if ($classeEleve) {
                $matieres = MatiereModel::all();
                foreach ($matieres as $matiere) {
                    $notes = NoteModel::where('classe_id', $classeEleve->classe_id)
                                    ->where('matiere_id', $matiere->id)
                                    ->get()->toArray();
                    if ($notes)
                        $this->calcul($notes, $eleve->id, $matiere->id, $classeEleve->classe_id);
                    else
                        trace_log("L'élève ayant l'id ".$eleve->id." qui est dans"
                                . "la classe ".$classeEleve->classe_id." n'a pas de "
                                . "note dans la matiere ".$matiere->id);
                }
            }else {
                trace_log("l'élève ayant l'id ".$eleve->id." n'est pas dans une "
                        . "classe");
            }
        }
        $job->delete();
        // recuperation de toutes les notes
    }

    // Calcul de moyenne
    public function calcul($notes, $eleve_id, $matiere_id, $classe_id) {
        $points = 0;
        $coefficient = 0;
        foreach ($notes as $note) {
            $noteeleve = NoteEleve::where('eleve_id', $eleve_id)
                    ->where('note_id', $note['id'])
                    ->first();
            $valeur = $noteeleve ? $noteeleve->valeur : 0;
            $points+=$valeur * $note['coefficient'];
            $coefficient+=$note['coefficient'];
        }
        $moy = $points / $coefficient;
        // recuperation de du coefficient
        $classematiere = ClasseMatiereModel::where('classe_id', $classe_id)
                ->where('matiere_id', $matiere_id)->first();
        // sauvegarde de la moyenne
        $moyenne = MoyenneModel::where('eleve_id', $eleve_id)
                ->where('matiere_id', $matiere_id)
                ->first();
        if ($moyenne) {
            $moyenne->valeur = $moy;
            $moyenne->coefficient_matiere = $classematiere->coefficient;
            $moyenne->save();
        } else {
            $moyenne = new MoyenneModel;
            $moyenne->eleve_id = $eleve_id;
            $moyenne->matiere_id = $matiere_id;
            $moyenne->valeur = $moy;
            $moyenne->valeur = $classematiere->coefficient;
            $moyenne->save();
        }
    }

}
