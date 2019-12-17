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
    
    public function __construct(SectionAnneeScolaireModel $sectionanneescolaire, 
            ClasseModel $classe, EleveModel $eleve) {
        $this->sectionanneescolaire = $sectionanneescolaire;
        $this->anneescolaire = $sectionanneescolaire->anneescolaire;
        $this->eleve = $eleve;
        $this->classe = $classe;
    }
    
    // construct rapport
    public function constuct(){
        // recuperation de la section en cours 
        $sectionanneescolaire = $this->sectionanneescolaire;
        $head = "Moyennes provisoires de ".$this->eleve->name." ".$this->eleve->surname."</br>";
        $head = $head . " ".$sectionanneescolaire->libelle."</br>";
        // recuperation de toutes les matieres de la classe
        $classesmatieres = ClasseMatiereModel::where('annee_scolaire_id', $this->anneescolaire->id)
                            ->where('classe_id', $this->classe->id)->get(); 
        $body = null;
        // recuperation de toutes les matieres
        foreach($classesmatieres as $classematiere){
            // trace_log("l'id de la matiere est ".$classematiere->matiere_id." et le libelle est ".$classematiere->matiere->libelle);
            $moyenne = MoyenneModel::where('eleve_id', $this->eleve->id)
                    ->where('matiere_id', $classematiere->matiere_id)
                    ->where('classe_id', $this->classe->id)
                    ->where('section_annee_scolaire_id', $sectionanneescolaire->id)
                    ->where('type_moyenne_id', 2)
                    ->first();
            if($moyenne)
                $body = $body .' '.$classematiere->matiere->libelle." : ".$moyenne->valeur." </br>";
        }
        $moyennesection = Moyennemodel::where('eleve_id', $this->eleve->id)
                    ->where('classe_id', $this->classe->id)
                    ->where('section_annee_scolaire_id', $sectionanneescolaire->id)
                    ->where('type_moyenne_id', 3)
                    ->first();
        $footer = null;
        if($moyennesection)
            $footer = $footer ."----------------------------------</br>".$sectionanneescolaire->libelle." : ".$moyennesection->valeur;
        if($body)
            $this->rapport = $head.$body.$footer;
    }
    
    // get rapport
    public function getRapport(){
        return $this->rapport;
    }
}

