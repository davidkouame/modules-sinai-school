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


class MoyenneJob{
    
    public function fire($job, $data = null) {
        try{
            // recuperation de l'annee scolaire
            $anneescolaire = $this->getAnnneeScolaireEnCours();
            $classeseleves = ClasseEleveModel::where('annee_scolaire_id', $anneescolaire->id)->get();
            $classeselevestab = new Collection([]);
            $classeseleves->each(function($element, $key) use($classeselevestab){
                $classeselevestab->push(["classeeleve_id" => $element->id, "classe_id" => $element->classe_id]);
            });
            $classeseleves = $classeselevestab->unique('classe_id')->values()->all();
            $sectionanneescolaire = $this->sectionAnneeScolaire();
            foreach($classeseleves as $classeeleve){
                $classeeleve = ClasseEleveModel::find($classeeleve['classeeleve_id']);
                // trace-log("")
                // dd($classeeleve->classe->eleves($anneescolaire->id));
                $eleves = $classeeleve && $classeeleve->classe
                        ? $classeeleve->classe->eleves($anneescolaire->id)
                        : null;
                // trace_log("============= nombre d'eleve pour cette classe est ". count($eleves));
                // dd(count($eleves));
                foreach($eleves as $eleve){
                    $rapportmoyenne = new RapportMoyenne($sectionanneescolaire, $classeeleve->classe, $eleve);
                    $rapportmoyenne->constuct();
                    $body = $rapportmoyenne->getRapport();
                    if($body){
                        $sms = new Sms;
                        $parent = ParentModel::find($eleve->parent_id);
                        if($parent)
                            $sms->send($parent->tel, $parent, $eleve, $body);
                    }
                    
                }
            }
           $this->saveSuccessJob($job);
        }catch(\Exception $e){
            trace_log($e);
        }
        $job->delete();
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
        // return AnneeScolaireModel::find(2);
        return $this->sectionAnneeScolaire()->anneescolaire;
    }

     // recuperation de la section en cours
    public function sectionAnneeScolaire(){
        // recuperation de l'annee scolaire
        // $date = date('Y-m-d');
        $date = "2020-06-27";
        $sectionanneescolaire = SectionAnneeScolaireModel::where('start', '<=',$date)
        ->where('end', '>=', $date)->first();
        if($sectionanneescolaire)
            trace_log("la section annee scolaire est ".$sectionanneescolaire->libelle);
        // to do
        return SectionAnneeScolaireModel::find(2);
    }
    
}