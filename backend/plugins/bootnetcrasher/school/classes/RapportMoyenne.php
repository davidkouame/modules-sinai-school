<?php

namespace Bootnetcrasher\School\Classes;
use BootnetCrasher\School\Models\EleveModel;
use BootnetCrasher\School\Models\ClasseModel;
use BootnetCrasher\School\Models\AnneeScolaireModel;
use BootnetCrasher\School\Models\ClasseMatiereModel;
use BootnetCrasher\School\Models\MoyenneModel;
use BootnetCrasher\School\Models\SectionAnneeScolaireModel;

class RapportMoyenne {
    
    private $eleve = null;
    private $classe = null;
    private $anneescolaire = null;
    private $sectionanneescolaire = null;
    private $rapport = null;
    private $estProvisoire = null;
    
    public function __construct(SectionAnneeScolaireModel $sectionanneescolaire = null, 
            ClasseModel $classe = null , EleveModel $eleve = null, $estProvisoire = null) {
        if($sectionanneescolaire){
            $this->sectionanneescolaire = $sectionanneescolaire;
            $this->anneescolaire = $sectionanneescolaire->anneescolaire;
            $this->eleve = $eleve;
            $this->classe = $classe;
            $this->estProvisoire = $estProvisoire;
        }
    }
    
    // construct rapport
    public function constuct(){
        // recuperation de la section en cours 
        $sectionanneescolaire = $this->sectionanneescolaire;
        if($sectionanneescolaire){
            $head = $this->getHead();
            $head = $head . " ".$sectionanneescolaire->libelle."\n";
            // recuperation de toutes les matieres de la classe
            $classesmatieres = ClasseMatiereModel::where('annee_scolaire_id', $this->anneescolaire->id)
                                ->where('classe_id', $this->classe->id)->get(); 
            $body = null;
            // recuperation de toutes les matieres
            foreach($classesmatieres as $classematiere){
                $moyenne = MoyenneModel::where('eleve_id', $this->eleve->id)
                        ->where('matiere_id', $classematiere->matiere_id)
                        ->where('classe_id', $this->classe->id)
                        ->where('section_annee_scolaire_id', $sectionanneescolaire->id)
                        ->where('type_moyenne_id', 2)
                        ->first();
                if($moyenne){
                    $body = $body .''.$classematiere->matiere->libelle." : ".$moyenne->valeur."/20";
                    if($classematiere->coefficient > 1)
                        $body = $body .";". $moyenne->valeur*$classematiere->coefficient."/".(String)($classematiere->coefficient*20);
                    $body = $body .(String)("\n");
                }
            }
            $moyennesection = Moyennemodel::where('eleve_id', $this->eleve->id)
                        ->where('classe_id', $this->classe->id)
                        ->where('section_annee_scolaire_id', $sectionanneescolaire->id)
                        ->where('type_moyenne_id', 3)
                        ->first();
            $footer = null;
            if($moyennesection){
                $footer = $footer ."----------------------------------\n".
                $sectionanneescolaire->libelle." : ".$moyennesection->valeur."/20";
                if($sectionanneescolaire->coefficient != 1){
                    $footer = $footer . ";".$moyennesection->valeur*$sectionanneescolaire->coefficient."/".$sectionanneescolaire->coefficient*20;
                }
            }
            if($body)
                $this->rapport = $head.$body.$footer;
        }
        
    }

    /**
     * Permet de construire un rapport de fin d'année scolaire
     * @param AnneeScolaireModel $anneescolaire
     * @param EleveModel $eleve
     * @param ClasseModel $classe
     */
    public function constructMoyenneAnnuelle(AnneeScolaireModel $anneescolaire, ClasseModel $classe, EleveModel $eleve){
        $head = "Bilan de l'année scolaire \nElève: ".$eleve->name." ".$eleve->surname."\n";
        $body = null;
        // recuperation de toutes les sections de l'année scolaire
        $sections = SectionAnneeScolaireModel::where('annee_scolaire_id', $anneescolaire->id)->get();
        foreach($sections as $section){
            $moyenne = MoyenneModel::where('eleve_id', $eleve->id)
                    ->where('classe_id', $classe->id)
                    ->where('section_annee_scolaire_id', $section->id)
                    ->where('type_moyenne_id', 3)
                    ->first();
            if($moyenne){
                $body = $body .''.$section->libelle." : ".$moyenne->valeur."/20";
                if($section->coefficient > 1)
                    $body = $body .";". $moyenne->valeur*$moyenne->coefficient."/".(String)($moyenne->coefficient*20);
                $body = $body .(String)("\n");
            }
        }
        $moyenneannuelle = Moyennemodel::where('eleve_id', $eleve->id)
                    ->where('classe_id', $classe->id)
                    ->where('annee_scolaire_id', $anneescolaire->id)
                    ->where('type_moyenne_id', 1)
                    ->first();
        $footer = null;
        if($moyenneannuelle){
            trace_log("nous avons une moyenne annuelle ");
            $footer = $footer ."----------------------------------\n";
            $footer = $footer."Moyenne annuelle : ".$moyenneannuelle->valeur."/20";
        }else{
            trace_log("nous n'avons pas une moyenne annuelle ");
        }
        if($body)
            $this->rapport = $head.$body.$footer;
    }
    
    // get rapport
    public function getRapport(){
        return $this->rapport;
    }

    // get heead
    public function getHead(){
        if($this->estProvisoire)
            return "Les moyennes provisoires du trimestre\nElève : ".$this->eleve->name." ".$this->eleve->surname."\nTrimestre : ";
        else
            return "Rapport de moyennes de fin de trimestre\nElève : ".$this->eleve->name." ".$this->eleve->surname."\nTrimestre : ";
    }
}

