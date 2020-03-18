<?php


namespace Bootnetcrasher\School\Classes;


use BootnetCrasher\School\Models\ClasseEleveModel;
use BootnetCrasher\School\Models\JobModel;
use BootnetCrasher\School\Models\JobSuccessModel;
use BootnetCrasher\School\Models\ParentModel;
use BootnetCrasher\School\Models\SectionAnneeScolaireModel;
use Illuminate\Support\Collection;
use Bootnetcrasher\School\Classes\Abonnement;

class MoyenneClasse
{
    private $sectionAnneeScolaire = null;
    private $estProvisoire = true;
    private $sectionAnneeScolaire_id = null;

    public function __construct(int $sectionAnneeScolaire_id)
    {
        $this->sectionAnneeScolaire_id = $sectionAnneeScolaire_id;
    }

    public function sendRapport(){
        $this->fire(["section_annnee_scolaire_id" => $this->sectionAnneeScolaire_id]);
    }

    public function fire($data = null) {
        try{
            $this->hydrate($data);
            // recuperation de toutes les classes eleves
            $classeseleves = $this->getClassesEleves();
            $sectionanneescolaire = $this->getSectionAnneeScolaire();
            foreach($classeseleves as $classeeleve){
                $classeeleve = ClasseEleveModel::find($classeeleve['classeeleve_id']);
                $eleves = $classeeleve && $classeeleve->classe
                    ? $classeeleve->classe->allEleves($this->getAnnneeScolaireEnCours()->id)
                    : null;
                foreach($eleves as $eleve){
                    if(Abonnement::hasAbonnement($eleve)){
                        $rapportmoyenne = new RapportMoyenne($sectionanneescolaire, $classeeleve->classe, $eleve, $this->estProvisoire);
                        $rapportmoyenne->constuct();
                        $body = $rapportmoyenne->getRapport();
                        if($body){
                            $sms = new Sms;
                            // $parent = ParentModel::find($eleve->parent_id);
                            $parent = Abonnement::getParentToAbonnement($eleve);
                            if($parent)
                                $sms->send($parent->tel, $body, $parent, $eleve);
                        }
                    }
                }
            }
        }catch(Exception $e){
            trace_log($e);
        }
    }

    // recuperation de tous les classes eleves
    public function getClassesEleves(){
        // recuperation de l'annee scolaire
        $anneescolaire = $this->getAnnneeScolaireEnCours();
        $classeseleves = ClasseEleveModel::where('annee_scolaire_id', $anneescolaire->id)->get();
        $classeselevestab = new Collection([]);
        $classeseleves->each(function($element, $key) use($classeselevestab){
            $classeselevestab->push(["classeeleve_id" => $element->id, "classe_id" => $element->classe_id]);
        });
        return  $classeselevestab->unique('classe_id')->values()->all();
    }

    // get annee scolaire en cours
    public function getAnnneeScolaireEnCours(){
        return $this->getSectionAnneeScolaire()->anneescolaire;
    }

    // recuperation de la section en cours
    public function getSectionAnneeScolaire(){
        if($this->sectionAnneeScolaire)
            return $this->sectionAnneeScolaire;
        else
            return SectionAnneeScolaireModel::find(1);
    }

    public function hydrate($data){
        if($data){
            if(array_key_exists("section_annee_scolaire_id", $data)){
                // recuperation de la section annee scolaire
                $this->sectionAnneeScolaire = SectionAnneeScolaireModel::find($data["section_annee_scolaire_id"]);
                $this->estProvisoire = false;
            }
        }
    }
}