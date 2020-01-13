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
use BootnetCrasher\School\Models\AnneeScolaireModel;
use BootnetCrasher\School\Models\SectionAnneeScolaireModel;

/**
 * Permet de calculer les moyennes des matières des sections année scolaire
 */
class CalculMoyenne {

    /**
     * Permet de calculer les moyennes des matieres de une ou de plusieurs sections
     * @param SectionAnneeScolaireModel $section
     */
    public function calculerLesMoyennesDesMatieres(SectionAnneeScolaireModel $section = null){
        if($section){
            $this->calculMoyenneMatiere($section);
        }else{
            // recuperation de l'année scolaire en cours
            $anneeScolaire = $this->getAnneeScolaire();
            // recuperation de toutes les sections de l'année scolaire
            $sectionsAnneeScolaire = SectionAnneeScolaireModel::
            where('annee_scolaire_id', $anneeScolaire->id)
            ->get();
            foreach($sectionsAnneeScolaire as $section){
                // cacul des moyennes des matieres de la section année scolaire
                $this->calculMoyenneMatiere($section);
            }
        }
    }
    
    /**
     * Permet de calculer les moyennes des matieres d'une section année scolaire
     * @param SectionAnneeScolaireModel $section
     */
    public function calculMoyenneMatiere(SectionAnneeScolaireModel $section){
        if($section){
            
            // recuperation de tous les élèves
            $eleves = EleveModel::all();
            foreach ($eleves as $eleve) {
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
                } 
            }
        }
        
    }

    /**
     * Permet de calculer les moyennes de sections d'une année scolaire
     * @param SectionAnneeScolaireModel $section
     */
    public function calculerLesMoyennesDeSections(){
        // recuperation de l'année scolaire en coure
        $anneeScolaire = $this->getAnneeScolaire();
        $eleves = EleveModel::all();
        foreach ($eleves as $eleve) {
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
                        // Calculer la moyenne de section 
                        $this->calculerLaMoyenneSection($section);
                    }
                }
            }
        }
    }

    /**
     * Permet de calculer la moyenne de section d'une année scolaire
     * @param SectionAnneeScolaireModel $section
     */
    public function calculerLaMoyenneSection(SectionAnneeScolaireModel $section){
        $eleves = EleveModel::all();
        foreach ($eleves as $eleve) {
            $classeEleve = ClasseEleveModel::where('eleve_id', $eleve->id)
                    ->where('annee_scolaire_id', $section->annee_scolaire_id)
                    ->first();
            if ($classeEleve) {
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
                    trace_log("calcul de la moyenne de section ");
                    trace_log("le coefficient section est ".$coefficientSection);
                    $valeur = $moyenneSection ? $moyenneSection / $coefficientSection : 0;
                    $this->saveMoyenneSection($valeur, $coefficientSection, $section->id, 3, $eleve->id, $classeEleve->classe_id);
                }
            }
        }
    }

    public function saveMoyenne($valeur, $coefficientSection, $sectionId, $typeMoyenneId, $eleveId, $classeId){
        trace_log("calcul de ma moyenne annuelle ");
        $moyenneModelSection = MoyenneModel::where('eleve_id', $eleveId)->
        where('type_moyenne_id', $typeMoyenneId)->where('classe_id', $classeId)->first();
        if($moyenneModelSection){
            $moyenneModelSection->valeur = $valeur;
            $moyenneModelSection->coefficient_section = $coefficientSection;
        }else{
            $moyenneModelSection = new MoyenneModel;
            $moyenneModelSection->valeur = $valeur;
            $moyenneModelSection->coefficient_section = $coefficientSection;
            $moyenneModelSection->section_annee_scolaire_id = $sectionId;
            $moyenneModelSection->type_moyenne_id = $typeMoyenneId;
            $moyenneModelSection->eleve_id = $eleveId;
            $moyenneModelSection->classe_id = $classeId;
        }
        $moyenneModelSection->save();
    }

    public function saveMoyenneAnnuelle($valeur, $anneeScolaireId, $typeMoyenneId, $eleveId, $classeId){
        trace_log("calcul de la moyenne annuelle ");
        $moyenneModelAnnuelle = MoyenneModel::where('eleve_id', $eleveId)->
        where('type_moyenne_id', $typeMoyenneId)->where('classe_id', $classeId)->first();
        if($moyenneModelAnnuelle){
            $$moyenneModelAnnuelle->valeur = $valeur;
        }else{
            $moyenneModelAnnuelle = new MoyenneModel;
            $moyenneModelAnnuelle->valeur = $valeur;
            $moyenneModelAnnuelle->annee_scolaire_id = $anneeScolaireId;
            $moyenneModelAnnuelle->type_moyenne_id = $typeMoyenneId;
            $moyenneModelAnnuelle->eleve_id = $eleveId;
            $moyenneModelAnnuelle->classe_id = $classeId;
        }
        $moyenneModelAnnuelle->save();
    }

    public function saveMoyenneSection($valeur, $coefficientSection, $sectionId, $typeMoyenneId, $eleveId, $classeId){
        $moyenneModelSection = MoyenneModel::where('eleve_id', $eleveId)->
        where('type_moyenne_id', 3)->where('classe_id', $classeId)
        ->where('section_annee_scolaire_id', $sectionId)->first();
        if($moyenneModelSection){
            $moyenneModelSection->valeur = $valeur;
            $moyenneModelSection->coefficient_section = $coefficientSection;
        }else{
            $moyenneModelSection = new MoyenneModel;
            $moyenneModelSection->valeur = $valeur;
            $moyenneModelSection->coefficient_section = $coefficientSection;
            $moyenneModelSection->section_annee_scolaire_id = $sectionId;
            $moyenneModelSection->type_moyenne_id = $typeMoyenneId;
            $moyenneModelSection->eleve_id = $eleveId;
            $moyenneModelSection->classe_id = $classeId;
        }
        $moyenneModelSection->save();
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
            // recuperation du coefficient de la matiere
            $classematiere = ClasseMatiereModel::where('classe_id', $classe_id)
                    ->where('matiere_id', $matiere_id)->first();
            if($classematiere){
                // trace_log("calcul des moyennes matieres");
                // sauvegarde de la moyenne
                $moyenne = MoyenneModel::where('eleve_id', $eleve_id)
                        ->where('matiere_id', $matiere_id)
                        ->where('section_annee_scolaire_id', $section_annee_scolaire_id)
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
            }else{
                trace_log("classe_id : ".$classe_id."; matiere_id :".$matiere_id);
            }
            
        }
    }

    /**
     * Permmet de recupérer l'année scolaire en cours
     * @return AnneeScolaireModel
     */
    public function getAnneeScolaire(){
        // todo recover annee scolaire en cours
        return AnneeScolaireModel::find(2);;
    }

    /**
     * Permet de calculer la moyenne annuelle
     * @param AnneeScolaireModel $section
     */
    public function calculerLaMoyenneAnnuelle(AnneeScolaireModel $anneescolaire){
        $eleves = EleveModel::all();
        foreach ($eleves as $eleve) {
            $classeEleve = ClasseEleveModel::where('eleve_id', $eleve->id)
                    ->where('annee_scolaire_id', $anneescolaire->id)
                    ->first();
            if ($classeEleve) {
                // recuperation de toutes les sections de l'année scolaire
                $sections = SectionAnneeScolaireModel::where('annee_scolaire_id', $anneescolaire->id)->get();
                $moyenneAnnuelle = null;
                $coefficientAnnuelle = null;
                foreach($sections as $section){
                    $moyenne = MoyenneModel::where('eleve_id', $eleve->id)
                            ->where('classe_id', $classeEleve->classe_id)
                            ->where('section_annee_scolaire_id', $section->id)
                            ->where('type_moyenne_id', 3)
                            ->first();
                    if($moyenne){
                        $moyenneAnnuelle += $moyenne->valeur * $section->coefficient;
                        $coefficientAnnuelle += $section->coefficient;
                    }
                }
                if($moyenneAnnuelle && $coefficientAnnuelle){
                    /*$moyenneModelAnnuelle = new MoyenneModel;
                    $moyenneModelAnnuelle->valeur = $moyenneAnnuelle ? $moyenneAnnuelle / $coefficientAnnuelle : 0;
                    $moyenneModelAnnuelle->annee_scolaire_id = $anneescolaire->id;
                    $moyenneModelAnnuelle->type_moyenne_id = 1;
                    $moyenneModelAnnuelle->eleve_id = $eleve->id;
                    $moyenneModelAnnuelle->classe_id = $classeEleve->classe_id;
                    $moyenneModelAnnuelle->save();*/
                    $valeur = $moyenneAnnuelle ? $moyenneAnnuelle / $coefficientAnnuelle : 0;
                    $this->saveMoyenneAnnuelle($valeur, $anneescolaire->id, 1, $eleve->id, $classeEleve->classe_id);
                }
            }
        }
    }
}
