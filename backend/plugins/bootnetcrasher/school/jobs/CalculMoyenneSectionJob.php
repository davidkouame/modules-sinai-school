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

class CalculMoyenneSectionJob {

    public function fire($job, $data = null) {
        $this->calculMoyenneMatiere();
        $this->calculMoyenneSection();
        $job->delete();
        // recuperation de toutes les notes
    }
    
    public function calculMoyenneSection(){
        $eleves = EleveModel::all();
        foreach ($eleves as $eleve) {
            if(Abonnement::hasAbonnement($eleve)){
                // recuperation de toutes les années scolaires
                $anneesScolaires = AnneeScolaireModel::all();
                foreach($anneesScolaires as $anneeScolaire){
                    $classeEleve = ClasseEleveModel::where('eleve_id', $eleve->id)
                            ->where('annee_scolaire_id', $anneeScolaire->id)
                            ->first();
                    if ($classeEleve) {
                        // recuperation de toutes les sections de l'année scolaire
                        $sectionsAnneeScolaire = SectionAnneeScolaireModel::
                                where('annee_scolaire_id', $anneeScolaire->id)
                                ->get();
                        foreach($sectionsAnneeScolaire as $section){
                            // recuperation de toutes les matieres de la classe
                            $classesMatieres = ClasseMatiereModel::where('classe_id', 
                                    $classeEleve->classe_id)->get();
                            $moyenneSection = null;
                            $coefficientSection = null;
                            foreach($classesMatieres as $classeMatiere){
                                // recuperation de la moyenne de l'élève dans cette
                                // matiere dans la section année scolaire
                                $moyenneModel = MoyenneModel::where('eleve_id', $eleve->id)
                                        ->where('matiere_id', $classeMatiere->matiere_id)
                                        ->where('section_annee_scolaire_id', $section->id)
                                        ->where('type_moyenne_id', 2)
                                        ->first();
                                if($moyenneModel){
                                    $moyenneSection += $moyenneModel->valeur * 
                                            $moyenneModel->coefficient_matiere;
                                    $coefficientSection += $moyenneModel->coefficient_matiere;
                                }
                            }
                            if($moyenneSection && $coefficientSection){
                                $moyenneModelSection = new MoyenneModel;
                                $moyenneModelSection->valeur = $moyenneSection ? $moyenneSection / $coefficientSection : 0;
                                $moyenneModelSection->coefficient_section = $coefficientSection;
                                $moyenneModelSection->section_annee_scolaire_id = $section->id;
                                $moyenneModelSection->type_moyenne_id = 3;
                                $moyenneModelSection->eleve_id = $eleve->id;
                                $moyenneModelSection->classe_id = $classeEleve->classe_id;
                                $moyenneModelSection->save();
                            }
                        }
                    }
                }
            }
        }
    }
}
