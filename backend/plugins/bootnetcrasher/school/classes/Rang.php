<?php

namespace Bootnetcrasher\School\Classes;

use BootnetCrasher\School\Models\NoteModel;
use BootnetCrasher\School\Models\NoteEleve;
use BootnetCrasher\School\Models\SectionAnneeScolaireModel;
use BootnetCrasher\School\Models\ClasseModel;
use BootnetCrasher\School\Models\MatiereModel;
use BootnetCrasher\School\Models\ClasseMatiereModel;
use BootnetCrasher\School\Models\MoyenneModel;
use BootnetCrasher\School\Models\AnneeScolaireModel;
use BootnetCrasher\School\Models\EleveModel;
use BootnetCrasher\School\Models\ClasseEleveModel;

class Rang {

    public function fire($job, $data = null) {
        // $this->rangNote();
        // $this->rangMoyenneMatiere();
        // $this->rangMoyenneSection();
            $this->rangMoyenneAnnuelle();
        $job->delete();
    }
    
    public function rangNote(){
            // recuperation de toutes les années scolaires
            // $anneesScolaires = AnneeScolaireModel::all();
            // foreach($anneesScolaires as $anneeScolaire){
                // recuperation de toutes les classes
                $classes = ClasseModel::all();
                trace_log("debut de la classe ");
                foreach($classes as $classe){
                    // recuperation de toutes les notes par classe
                    // $notes = NoteModel::where('classe_id', $classe->id)->get();
                    $notes = NoteModel::where('classe_id', $classe->id)->get();
                    // trace_log(">>>>>>>>>>>>>>>> Classement pour cette note");
                    foreach($notes as $note){
                        // trace_log("note ".$note->id);
                        $noteseleves = NoteEleve::where('note_id', $note->id)
                                 ->orderBy('valeur', 'desc')
                                ->get();
                        // trace_log("debut de classement pour cette note");
                        $ranges = [];
                        $position = 1;
                        foreach($noteseleves as $key => $noteeleve){
                            $count = NoteEleve::where('note_id', $note->id)
                                    ->where('valeur', $noteeleve->valeur)
                                 ->orderBy('valeur', 'desc')
                                ->count();
                            if(!array_key_exists($noteeleve->valeur, $ranges)){
                                // $ranges[$noteeleve->valeur] = $count;
                                $ranges1 = [];
                                $ranges1["valeur"] = $noteeleve->valeur;
                                $ranges1["count"] = $count;
                                $ranges1["position"] = $position;
                                $ranges[$noteeleve->valeur] = $ranges1;
                                $position += $count;
                            }
                            // trace_log("note id:".$noteeleve->note_id.", eleve id:".$noteeleve->eleve_id.", valeur:".$noteeleve->valeur);
                        }
                        foreach($noteseleves as $key => $noteeleve){
                            $noteeleve->rang = $ranges[$noteeleve->valeur]["position"];
                            $noteeleve->save();
                        }
                        // trace_log("Debut du classement pour cette note");
                        // foreach($noteseleves as $key => $noteeleve){
                        //      trace_log("note id:".$noteeleve->note_id.", eleve id:".$noteeleve->eleve_id.", valeur:".$noteeleve->valeur.", rang:".$noteeleve->rang);
                        // }
                        // trace_log("fin du classement pour cette note");
                        // dd($ranges);
                        /*$position = 0;
                        foreach($ranges as $key => $range){
                            if($position == 0){
                                $position 
                            }
                        }*/
                        // foreach($ranges as $key => $range){
                        //     trace_log("key:".$key.", value:".$range);
                        // }
                        // ("fin de classement pour cette note");
                        // trace_log("le tableau ordonné est ");
                    }
                    // trace_log(">>>>>>>>>>>>>>>> find de Classement pour cette note");
                }
            // }
    }
    
    public function rangMoyenneMatiere(){
        // recuperation de toutes les classes
        $classes = ClasseModel::all();
        foreach ($classes as $classe){
            // recuperation de toutes les matieres concernant cette classe
            $classesmatieres = ClasseMatiereModel::where('classe_id', $classe->id)
                    ->get();
            foreach($classesmatieres as $classematiere){
                // recuperation de toutes les sections d'année scolaire
                $sections = SectionAnneeScolaireModel::all();
                
                foreach ($sections as $section){
                    // recuperation de toutes les moyennes concernant la matiere
                    $moyennes = MoyenneModel::where('classe_id', $classematiere->classe_id)
                            ->where('matiere_id', $classematiere->matiere_id)
                            ->where('section_annee_scolaire_id', $section->id)
                            ->where('type_moyenne_id', 2)
                            ->orderBy('valeur', 'desc')
                            ->get();
                    $ranges = [];
                    $position = 1;
                    foreach($moyennes as $key => $moyenne){
                        $moyennesSearch = MoyenneModel::where('classe_id', $classematiere->classe_id)
                                    ->where('matiere_id', $classematiere->matiere_id)
                                    ->where('section_annee_scolaire_id', $section->id)
                                    ->where('type_moyenne_id', 2)
                                    // ->where('valeur', (String) $moyenne->valeur)
                                    // ->count();
                                    ->get();
                        $count = 0;
                        if($moyennesSearch){
                            $count = $moyennesSearch->filter(function($value, $key) use($moyenne){
                                        return((String) $value->valeur) == ((String)$moyenne->valeur);
                                    })->count();
                        }
                        
                        if(!array_key_exists((String)$moyenne->valeur, $ranges)){
                            // $ranges[$noteeleve->valeur] = $count;
                            $ranges1 = [];
                            $ranges1["valeur"] = (String)$moyenne->valeur;
                            $ranges1["count"] = $count;
                            $ranges1["position"] = $position;
                            $ranges[(String)$moyenne->valeur] = $ranges1;
                            $position += $count;
                        }
                        // trace_log("la valeur recherchée est : ".$moyenne->valeur.", le nombre trouvé est :".$count);
                        // trace_log("note id:".$noteeleve->note_id.", eleve id:".$noteeleve->eleve_id.", valeur:".$noteeleve->valeur);
                    }
                    foreach($moyennes as $key => $moyenne){
                        $moyenne->rang = $ranges[(String)$moyenne->valeur]["position"];
                        $moyenne->save();
                    }
                    // trace_log("Debut du classement pour cette matiere");
                    // foreach($ranges as $key => $range){
                    //    trace_log("id :".$key.", value:".$range["count"]);
                    // }
                    // trace_log("fin du classement pour cette note");
                    // trace_log("debut du deroulement de la moyenne");
                    // foreach($moyennes as $moyenne){
                    //     trace_log("l'id de la moyenne est :".$moyenne->id.", la valeur de la moyenne est ".$moyenne->valeur);
                    // }
                    // trace_log("fin du deroulement de la moyenne");
                }
            }
        }
        
        
        // recuperation de toutes les matieres
        $matieres = MatiereModel::all();
        foreach($matieres as $matiere){
            // recuperation de toutes les sections
            $sections = SectionAnneeScolaireModel::all();
        }
    }
    
    public function rangMoyenneSection(){
        // recuperation de tous les élèves
        $eleves = EleveModel::all();
        foreach ($eleves as $eleve) {
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
                        // recuperation de toutes les moyennes des eleves de la
                        // classe
                        $moyennes = MoyenneModel::where('classe_id', $classeEleve->classe_id)
                                    ->where('section_annee_scolaire_id', $section->id)
                                    ->where('type_moyenne_id', 3)
                                    ->orderBy('valeur', 'desc')
                                    ->get();
                        $ranges = [];
                        $position = 1;
                        foreach($moyennes as $key => $moyenne){
                            $moyennesSearch = MoyenneModel::where('classe_id', $classeEleve->classe_id)
                                    ->where('section_annee_scolaire_id', $section->id)
                                    ->where('type_moyenne_id', 3)
                                    ->orderBy('valeur', 'desc')
                                    ->get();
                            $count = 0;
                            if($moyennesSearch){
                                $count = $moyennesSearch->filter(function($value, $key) use($moyenne){
                                        return((String) $value->valeur) == ((String)$moyenne->valeur);
                                    })->count();
                            }
                            if(!array_key_exists((String)$moyenne->valeur, $ranges)){
                                // $ranges[$noteeleve->valeur] = $count;
                                $ranges1 = [];
                                $ranges1["valeur"] = (String)$moyenne->valeur;
                                $ranges1["count"] = $count;
                                $ranges1["position"] = $position;
                                $ranges[(String)$moyenne->valeur] = $ranges1;
                                $position += $count;
                            }
                        }
                        foreach($moyennes as $key => $moyenne){
                            $moyenne->rang = $ranges[(String)$moyenne->valeur]["position"];
                            $moyenne->save();
                        }
                    }
                }
            }
            
        }
    }
    
    public function rangMoyenneAnnuelle(){
        // recuperation de tous les élèves
        $eleves = EleveModel::all();
        foreach ($eleves as $eleve) {
            // recuperation de toutes les années scolaires
            $anneesScolaires = AnneeScolaireModel::all();
            foreach($anneesScolaires as $anneeScolaire){
                $classeEleve = ClasseEleveModel::where('eleve_id', $eleve->id)
                        ->where('annee_scolaire_id', $anneeScolaire->id)
                        ->first();
                if ($classeEleve) {
                    // recuperation de toutes les moyennes annuelles 
                    // des eleves de la classe
                    $moyennes = MoyenneModel::where('classe_id', $classeEleve->classe_id)
                                ->where('annee_scolaire_id', $anneeScolaire->id)
                                ->where('type_moyenne_id', 1)
                                ->orderBy('valeur', 'desc')
                                ->get();
                    $ranges = [];
                    $position = 1;
                    foreach($moyennes as $key => $moyenne){
                        $moyennesSearch = MoyenneModel::where('classe_id', $classeEleve->classe_id)
                                ->where('annee_scolaire_id', $anneeScolaire->id)
                                ->where('type_moyenne_id', 1)
                                ->orderBy('valeur', 'desc')
                                ->get();
                        $count = 0;
                        if($moyennesSearch){
                            $count = $moyennesSearch->filter(function($value, $key) use($moyenne){
                                    return((String) $value->valeur) == ((String)$moyenne->valeur);
                                })->count();
                        }
                        if(!array_key_exists((String)$moyenne->valeur, $ranges)){
                            // $ranges[$noteeleve->valeur] = $count;
                            $ranges1 = [];
                            $ranges1["valeur"] = (String)$moyenne->valeur;
                            $ranges1["count"] = $count;
                            $ranges1["position"] = $position;
                            $ranges[(String)$moyenne->valeur] = $ranges1;
                            $position += $count;
                        }
                    }
                    foreach($moyennes as $key => $moyenne){
                        $moyenne->rang = $ranges[(String)$moyenne->valeur]["position"];
                        $moyenne->save();
                    }
                }
            }
            
        }
    }
}
