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
use Bootnetcrasher\School\Classes\Abonnement;

class CalculMoyenneMatiereJob {

    public function fire($job, $data = null) {
        if(array_key_exists("section_annee_scolaire_id", $data)){
            $this->calculMoyenneMatiereSection($data["section_annee_scolaire_id"]);
        }else{
            $this->calculMoyenneMatiere();
        }
        $job->delete();
    }

    // calcul de moyenne des matieres pour une section
    public function calculMoyenneMatiereSection($section_annee_scolaire_id){
        $section = SectionAnneeScolaireModel::find($section_annee_scolaire_id);
        $eleves = EleveModel::all();
        foreach ($eleves as $eleve) {
            if(Abonnement::hasAbonnement($eleve)){
                $classeEleve = ClasseEleveModel::where('eleve_id', $eleve->id)
                    ->where('annee_scolaire_id', $section->annee_scolaire_id)
                    ->first();
                if ($classeEleve) {
                    $matieres = MatiereModel::all();
                    foreach ($matieres as $matiere) {
                        $notes = NoteModel::where('classe_id', $classeEleve->classe_id)
                            ->where('matiere_id', $matiere->id)
                            ->where('section_annee_scolaire_id', $section->id)
                            ->get()->toArray();
                        if ($notes)
                            $this->calculMatiere($notes, $eleve->id, $matiere->id,
                                $classeEleve->classe_id,
                                $section->id);
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
        }
    }

    // calcul de moyenne matiere
    public function calculMoyenneMatiere(){
        // recuperation de tous les élèves
        $eleves = EleveModel::all();
        foreach ($eleves as $eleve) {
            if(Abonnement::hasAbonnement($eleve)){
                // recuperation de toutes les années scolaires
                // $anneesScolaires = AnneeScolaireModel::all();
                $anneeScolaire = AnneeScolaireModel::find(2);
                // foreach($anneesScolaires as $anneeScolaire){
                    $classeEleve = ClasseEleveModel::where('eleve_id', $eleve->id)
                            ->where('annee_scolaire_id', $anneeScolaire->id)
                            ->first();
                    if ($classeEleve) {
                        // recuperation de toutes les sections de l'année scolaire
                        $sectionsAnneeScolaire = SectionAnneeScolaireModel::
                                where('annee_scolaire_id', $anneeScolaire->id)
                                ->get();
                        foreach($sectionsAnneeScolaire as $section){
                            $matieres = MatiereModel::all();
                            foreach ($matieres as $matiere) {
                                $notes = NoteModel::where('classe_id', $classeEleve->classe_id)
                                                ->where('matiere_id', $matiere->id)
                                                ->where('section_annee_scolaire_id', $section->id)
                                                ->get()->toArray();
                                if ($notes)
                                    $this->calculMatiere($notes, $eleve->id, $matiere->id, 
                                            $classeEleve->classe_id,
                                            $section->id);
                                else
                                    trace_log("L'élève ayant l'id ".$eleve->id." qui est dans"
                                            . "la classe ".$classeEleve->classe_id." n'a pas de "
                                            . "note dans la matiere ".$matiere->id);
                            }
                        }
                    }else {
                        trace_log("l'élève ayant l'id ".$eleve->id." n'est pas dans une "
                                . "classe");
                    } 
                // }
            }
        }
    }

    // Calcul de moyenne des matieres
    public function calculMatiere($notes, $eleve_id, $matiere_id, $classe_id, 
            $section_annee_scolaire_id) {
        $points = null;
        $coefficient = null;
        foreach ($notes as $note) {
            $noteeleve = NoteEleve::where('eleve_id', $eleve_id)
                    ->where('note_id', $note['id'])
                    ->first();
            if($noteeleve){
                $valeur = $noteeleve->valeur;
                $points+=$valeur * $note['coefficient'];
                $coefficient+=$note['coefficient'];
            }
            
        }
        if($points && $coefficient){
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
                $moyenne->classe_id  = $classe_id;
                $moyenne->type_moyenne_id  = 2;
                $moyenne->section_annee_scolaire_id = $section_annee_scolaire_id;
                $moyenne->save();
            } else {
                $moyenne = new MoyenneModel;
                $moyenne->eleve_id = $eleve_id;
                $moyenne->matiere_id = $matiere_id;
                $moyenne->valeur = $moy;
                $moyenne->coefficient_matiere = $classematiere->coefficient;
                $moyenne->classe_id  = $classe_id;
                $moyenne->type_moyenne_id  = 2;
                $moyenne->section_annee_scolaire_id = $section_annee_scolaire_id;
                $moyenne->save();
            }
        }
    }
}
