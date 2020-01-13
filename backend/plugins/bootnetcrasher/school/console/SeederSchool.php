<?php namespace Bootnetcrasher\School\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use BootnetCrasher\School\Models\NoteModel;
use BootnetCrasher\School\Models\ClasseModel;
use BootnetCrasher\School\Models\AnneeScolaireModel;
use BootnetCrasher\School\Models\ClasseMatiereModel;
use BootnetCrasher\School\Models\MatiereModel;
use BootnetCrasher\School\Models\SectionAnneeScolaireModel;
use DB;

use October\Rain\Database\Updates\Seeder;

class SeederSchool extends Command
{
    /**
     * @var string The console command name.
     */
    protected $name = 'school:seeder';

    /**
     * @var string The console command description.
     */
    protected $description = 'No description provided yet...';

    /**
     * Execute the console command.
     * @return void
     */

    private $sectionAnneeScolaire = null;

    public function handle()
    {
        // recuperation de l'annee scolaire
        $anneeScolaire = $this->getAnneeScolaire();
        // recuperation de la section année scolaire
        $this->sectionAnneeScolaire = $this->getSectionAnneescolaire();
        // recuepartion de toutes les classes
        $classes = ClasseModel::where('annee_scolaire_id', $anneeScolaire->id)->get();
        foreach($classes as $classe){
            $this->generateNoteByClass($classe);
        }
        $this->output->writeln('Les notes ont été crées avec succès !');
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

    // generate a note for this class
    public function generateNoteByClass($classe){
        // recuperation de toutes matieres de la classe
        $classesProfesseursMatieres = ClasseMatiereModel::where('classe_id', $classe->id)->get();
        $classesProfesseursMatieres->each(function($item, $key){
            $this->createNotes($item);
        });

        // recuperation de toutes les notes
        $notes = DB::table('bootnetcrasher_school_note')->where('classe_id', $classe->id)->get();
        $notes->each(function($item, $key) use($classe){
            $elevesClasse = DB::table('bootnetcrasher_school_classe_eleve')
            ->where('classe_id', $classe->id)->get();
            $elevesClasse->each(function($elements, $kyesElements) use($item) {
                $noteEleve = DB::table('bootnetcrasher_school_note_eleve')
                ->where(['note_id' => $item->id,'eleve_id' => $elements->eleve_id])
                ->first();
                // Log::info("l'id de la note est ".$item->id);
                if(!$this->checkNoteEleve($noteEleve)){
                    // suppression de l'existant s'il existe
                    if($noteEleve){
                        DB::table('bootnetcrasher_school_note_eleve')
                        ->where(['note_id' => $item->id,'eleve_id' => $elements->eleve_id])
                        ->delete();
                    }
                    DB::table('bootnetcrasher_school_note_eleve')->insert([
                        'note_id' => $item->id,
                        'eleve_id' => $elements->eleve_id,
                        'valeur' => rand(8,15),
                        'created_at' => date("Y-m-d H:i:s"),
                        'updated_at' => date("Y-m-d H:i:s")
                    ]);
                }
            });
        });
    }

    // création des 3 notes pour chaque matière
    public function createNotes($item){
        trace_log("matiere ".$item->matiere_id);
    	// reuperation de la matiere
    	$matiere = MatiereModel::where('id', $item->matiere_id)->first();
    	$libelle = 'note 1 '.$matiere->libelle;
        $note = NoteModel::where('libelle', $libelle)
        ->where('matiere_id', $matiere->id)
        ->where('section_annee_scolaire_id', $this->sectionAnneeScolaire->id)
        ->where('classe_id', $item->classe_id)
        ->first();
    	if(!$note){
    		DB::table('bootnetcrasher_school_note')->insert([
	    		'libelle' => 'note 1 '.$matiere->libelle,
	    		'datenoteeffectue' => date("Y-m-d H:i:s"),
	    		'description' => 'note 1 '.$matiere->libelle,
	    		'typenote_id' => 1,
	    		'matiere_id' => $matiere->id,
	    		'coefficient' => 1,
                'reference' => rand(1, 10),
                'section_annee_scolaire_id' => $this->sectionAnneeScolaire->id,
	    		'classe_id' => $item->classe_id,
	    		'professeur_id' => $item->professeur_id,
	    		'created_at' => date("Y-m-d H:i:s"),
		        'updated_at' => date("Y-m-d H:i:s")
	    	]);
    	}
    	$libelle = 'note 2 '.$matiere->libelle;
        $note = DB::table('bootnetcrasher_school_note')->where('libelle', $libelle)
        ->where('matiere_id', $matiere->id)
        ->where('section_annee_scolaire_id', $this->sectionAnneeScolaire->id)
        ->where('classe_id', $item->classe_id)
        ->first();
    	if(!$note){
    		DB::table('bootnetcrasher_school_note')->insert([
	    		'libelle' => 'note 2 '.$matiere->libelle,
	    		'datenoteeffectue' => date("Y-m-d H:i:s"),
	    		'description' => 'note 2 '.$matiere->libelle,
	    		'typenote_id' => 2,
	    		'matiere_id' => $matiere->id,
	    		'coefficient' => 2,
	    		'reference' => rand(1, 10),
                'classe_id' => $item->classe_id,
                'section_annee_scolaire_id' => $this->sectionAnneeScolaire->id,
	    		'professeur_id' => $item->professeur_id,
	    		'created_at' => date("Y-m-d H:i:s"),
		        'updated_at' => date("Y-m-d H:i:s")
	    	]);
    	}
    	$libelle = 'note 3 '.$matiere->libelle;
        $note = DB::table('bootnetcrasher_school_note')->where('libelle', $libelle)
        ->where('matiere_id', $matiere->id)
        ->where('section_annee_scolaire_id', $this->sectionAnneeScolaire->id)
        ->where('classe_id', $item->classe_id)
        ->first();
    	if(!$note){
    		DB::table('bootnetcrasher_school_note')->insert([
	    		'libelle' => 'note 3 '.$matiere->libelle,
	    		'datenoteeffectue' => date("Y-m-d H:i:s"),
	    		'description' => 'note 3 '.$matiere->libelle,
	    		'typenote_id' => 2,
	    		'matiere_id' => $matiere->id,
	    		'coefficient' => 2,
	    		'reference' => rand(1, 10),
                'classe_id' => $item->classe_id,
                'section_annee_scolaire_id' => $this->sectionAnneeScolaire->id,
	    		'professeur_id' => $item->professeur_id,
	    		'created_at' => date("Y-m-d H:i:s"),
		        'updated_at' => date("Y-m-d H:i:s")
	    	]);
    	}
    }

    // Nous vérifions si la note eleve est conforme
    public function checkNoteEleve($eleveNote){
        $note = null;
        $eleve = null;
        
        if($eleveNote){
            $note = DB::table('bootnetcrasher_school_note')->where('id', $eleveNote->note_id)->first();
            $eleve = DB::table('bootnetcrasher_school_eleve')->where('id', $eleveNote->eleve_id)->first();
        }if($eleveNote && $eleveNote->note_id == 22){
            // dd($note);
        }
        return $eleveNote && $note && $eleve;
    }

    public function getAnneeScolaire(){
        return AnneeScolaireModel::find(1);
    }

    public function getSectionAnneescolaire(){
        return SectionAnneeScolaireModel::find(3);
    }
}
