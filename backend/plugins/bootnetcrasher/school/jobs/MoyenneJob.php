<?php

namespace Bootnetcrasher\School\Jobs;

use BootnetCrasher\School\Models\JobSuccessModel;
use BootnetCrasher\School\Models\JobModel;
use BootnetCrasher\School\Models\ClasseEleveModel;
use BootnetCrasher\School\Models\ParentModel;
use Bootnetcrasher\School\Classes\RapportMoyenne;
use Bootnetcrasher\School\Classes\Sms;
use BootnetCrasher\School\Models\AnneeScolaireModel;
use BootnetCrasher\School\Models\SectionAnneeScolaireModel;
use Illuminate\Support\Collection;
use DB;

/**
 * Elle permet d'envoyer un billan à la validation d'une section d'annee
 * scolaire
 */
class MoyenneJob{

    private $sectionAnneeScolaire = null;
    private $estProvisoire = true;

    public function fire($job, $data = null) {
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
                    $rapportmoyenne = new RapportMoyenne($sectionanneescolaire, $classeeleve->classe, $eleve, $this->estProvisoire);
                    $rapportmoyenne->constuct();
                    $body = $rapportmoyenne->getRapport();
                    if($body){
                        $sms = new Sms;
                        $parent = ParentModel::find($eleve->parent_id);
                        if($parent)
                            $sms->sendQueue($parent->tel, $body, $parent, $eleve);
                    }
                    
                }
            }
           $this->saveSuccessJob($job);
        }catch(\Exception $e){
            trace_log($e);
        }
        $job->delete();
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
    
    // save success job
    public function saveSuccessJob($jobP){
        $job = JobModel::find($jobP->getJobId());
        if($job){
            $jobSuccess = new JobSuccessModel;
            $jobSuccess->queue = $job->queue;
            $jobSuccess->payload = $job->payload;
            $jobSuccess->attempts = $job->attempts;
            $jobSuccess->reserved_at = $job->reserved_at;
            $jobSuccess->available_at = $job->available_at;
            $jobSuccess->created_at = $job->created_at;
            $jobSuccess->created_date_at = now();
            $jobSuccess->save();
        }
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