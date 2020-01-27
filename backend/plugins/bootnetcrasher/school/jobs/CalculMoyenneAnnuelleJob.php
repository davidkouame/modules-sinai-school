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

class CalculMoyenneAnnuelleJob {

    public function fire($job, $data = null) {
        $this->calculMoyenneAnnuelle();
        $job->delete();
        // recuperation de toutes les notes
    }
    
    public function calculMoyenneAnnuelle(){
        $eleves = EleveModel::all();
        foreach ($eleves as $eleve) {
            if(Abonnement::hasAbonnement($eleve)){
                // recuperation de toutes les années scolaires
                $anneesScolaires = AnneeScolaireModel::all();
                foreach($anneesScolaires as $anneeScolaire){
                    // recuperation de toutes les sections de l'année scolaire
                    $sectionsAnneeScolaire = SectionAnneeScolaireModel::
                            where('annee_scolaire_id', $anneeScolaire->id)
                            ->get();
                    $moyenneAnnuelle = null;
                    $coefficientAnnuelle = null;
                    $classeId = null;
                    foreach($sectionsAnneeScolaire as $section){
                        $moyenneSection = MoyenneModel::where('section_annee_scolaire_id', $section->id)
                                ->where('eleve_id', $eleve->id)
                                ->where('type_moyenne_id', 3)
                                ->first();
                        if($moyenneSection){
                            $classeId = $moyenneSection->classe_id;
                            if($eleve->id == 6){
                                trace_log("moyenne annuelle ".$moyenneSection->valeur . " coefficient ".$moyenneSection->sectionanneescolaire->coefficient);
                            }
                            $moyenneAnnuelle += $moyenneSection->valeur * 
                                    $moyenneSection->sectionanneescolaire->coefficient;
                            $coefficientAnnuelle += $moyenneSection->sectionanneescolaire->coefficient;
                        }
                    }
                    if($moyenneAnnuelle && $coefficientAnnuelle){
                        $moyenneModelAnnuelle = new MoyenneModel;
                        $moyenneModelAnnuelle->valeur = $coefficientAnnuelle ? $moyenneAnnuelle / $coefficientAnnuelle : 0;
                        $moyenneModelAnnuelle->coefficient_section = $coefficientAnnuelle;
                        $moyenneModelAnnuelle->annee_scolaire_id = $anneeScolaire->id;
                        $moyenneModelAnnuelle->type_moyenne_id = 1;
                        $moyenneModelAnnuelle->eleve_id = $eleve->id;
                        $moyenneModelAnnuelle->classe_id = $classeId;
                        $moyenneModelAnnuelle->save();
                    }
                }
            }
        }
    }
}
