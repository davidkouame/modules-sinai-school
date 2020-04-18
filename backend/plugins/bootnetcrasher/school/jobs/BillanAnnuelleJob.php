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
use Bootnetcrasher\School\Classes\CalculMoyenne;
use Illuminate\Support\Collection;
use Bootnetcrasher\School\Classes\Abonnement;
use DB;
use Mail;

/**
 * Elle permet d'envoyer un billan annuelle aux parents d'élèves
 */
class BillanAnnuelleJob{

    private $sectionAnneeScolaire = null;
    private $estProvisoire = true;
    private $anneeScolaire = null;

    public function fire($job, $data = null) {
        try{
            // recuperation de l'année scolaire en cours
            $anneescolaire = AnneeScolaireModel::find($data["annee_scolaire_id"]);
            $this->setAnneeScolaire($anneescolaire);
            // Calculer la moyenne annuelle
            $this->calculerLaMoyenneAnnuelle($anneescolaire);
            // Envoyer les billans aux parents 
            $this->sendBillan($anneescolaire);
           $this->saveSuccessJob($job);
        }catch(\Exception $e){
            trace_log($e);
        }
        $job->delete();
    }

    /**
     * Permet d'envoyer les billans annuels aux parents d'élèves
     * @param AnneeScolaireModel $anneescolaire
     */
    public function sendBillan(AnneeScolaireModel $anneescolaire){
        // recuperation de toutes les classes eleves
        $classeseleves = $this->getClassesEleves();
        foreach($classeseleves as $classeeleve){
            $classeeleve = ClasseEleveModel::find($classeeleve['classeeleve_id']);
            $eleves = $classeeleve && $classeeleve->classe
                    ? $classeeleve->classe->allEleves($anneescolaire->id)
                    : null;
            foreach($eleves as $eleve){
                if(Abonnement::hasAbonnement($eleve, $anneescolaire)){
                    $rapportmoyenne = new RapportMoyenne();
                    $rapportmoyenne->constructMoyenneAnnuelle($anneescolaire, $classeeleve->classe, $eleve);
                    $body = $rapportmoyenne->getRapport();
                    if($body){
                        $sms = new Sms;
                        // $parent = ParentModel::find($eleve->parent_id);
                        $abonnement = Abonnement::getParentToAbonnement($eleve, $anneescolaire);
                        $parent = Abonnement::getParentToAbonnement($eleve, $anneescolaire);

                        // Send sms
                        if($parent && $abonnement){
                            $sms->sendQueue($parent->tel, $body, $parent, $eleve, $abonnement);
                        }
                        
                        // Send email
                        $email = $parent->email;
                        $vars = ["body" => $body];
                        Mail::queue('school::mail.rapport.moyenne', $vars, function($message) use($email){
                            $message->to($email, 'Admin Person');
                            $message->subject('This is a reminder');
                        });
                    }
                }
            }
        }
    }

    /**
     * Permet de calculer la moyenne annuelle
     * @param AnneeScolaireModel $anneescolaire
     */
    public function calculerLaMoyenneAnnuelle(AnneeScolaireModel $anneescolaire){
        $calculMoyenne = new CalculMoyenne();
        $calculMoyenne->calculerLaMoyenneAnnuelle($anneescolaire);
    }

    // recuperation de tous les classes eleves
    public function getClassesEleves(){
        // recuperation de l'annee scolaire
        $anneescolaire = $this->getAnneeScolaire();
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

    // Recuperation de l'année scolaire
    public function getAnneeScolaire(){
        return $this->anneeScolaire;
    }

    public function setAnneeScolaire($anneeScolaire = null){
        $this->anneeScolaire = $anneeScolaire;
    }
    
}