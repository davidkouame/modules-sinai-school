<?php namespace Bootnetcrasher\School\Console;

use BootnetCrasher\School\Models\AnneeScolaireModel;
use BootnetCrasher\School\Models\ClasseEleveModel;
use BootnetCrasher\School\Models\ClasseMatiereModel;
use BootnetCrasher\School\Models\EleveModel;
use BootnetCrasher\School\Models\MatiereModel;
use BootnetCrasher\School\Models\MoyenneModel;
use BootnetCrasher\School\Models\NoteEleve;
use BootnetCrasher\School\Models\NoteModel;
use BootnetCrasher\School\Models\SectionAnneeScolaireModel;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Bootnetcrasher\School\Classes\Abonnement;

use October\Rain\Database\Updates\Seeder;

class CalculMoyenne extends Command
{
    /**
     * @var string The console command name.
     */
    protected $name = 'school:calculMoyennes';

    /**
     * @var string The console command description.
     */
    protected $description = 'No description provided yet...';

    /**
     * Execute the console command.
     * @return void
     */
    public function handle()
    {
        $this->calculMoyenneMatiere();
        $this->calculMoyenneSection();
        $this->calculMoyenneAnnuelle();
    }

    /**
     * Get the console command arguments.
     * @return array
     */
    protected function getArguments()
    {
        return [];
    }

    /**
     * Get the console command options.
     * @return array
     */
    protected function getOptions()
    {
        return [];
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
