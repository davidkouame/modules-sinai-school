<?php namespace BootnetCrasher\School\Models;

use Model;
use Bootnetcrasher\School\Classes\Sms;
use Backend\Facades\BackendAuth;
use BootnetCrasher\School\Models\ClasseEleveModel;
use BootnetCrasher\School\Models\EleveModel;
use Backend\Models\User;
use BootnetCrasher\School\Models\ParentModel;
/**
 * Model
 */
class NoteModel extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];


    /**
     * @var string The database table used by the model.
     */
    public $table = 'bootnetcrasher_school_note';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];
    
    public $belongsTo = [
        'typenote' => ['BootnetCrasher\School\Models\TypeNoteModel', 'key' => 'typenote_id', 'otherKey' => 'id'],
        'sectionanneescolaire' => ['BootnetCrasher\School\Models\SectionAnneeScolaireModel', 'key' => 'section_annee_scolaire_id', 'otherKey' => 'id'],
        'matiere' => ['BootnetCrasher\School\Models\MatiereModel', 'key' => 'matiere_id', 'otherKey' => 'id'],
        'professeur' => ['BootnetCrasher\School\Models\ProfesseurModel', 'key' => 'professeur_id', 'otherKey' => 'id'],
        'classe' => ['BootnetCrasher\School\Models\ClasseModel', 'key' => 'classe_id', 'otherKey' => 'id']
    ];
    
    public $hasMany = [
        'elevesnotes' => [
            'BootnetCrasher\School\Models\NoteEleve',
            'key' => 'eleve_id'
        ],
        'noteseleves' => [
            'BootnetCrasher\School\Models\NoteEleve',
            'key' => 'note_id'
        ]
    ];

    public $belongsToMany = [
        'eleves' => [
            'BootnetCrasher\School\Models\EleveModel',
            'table' => 'bootnetcrasher_school_note_eleve',
            'key' => 'note_id',
            'otherKey' => 'eleve_id'
        ]
    ];

    public function beforeCreate()
    {
        $this->reference = $this->getReference();
        $user = BackendAuth::getUser();
        $this->backend_user_id = $user ? $user->id : null;
        // trace_log("user = ".BackendAuth::getUser());
    }

    public function beforeSave(){
        /// trace_log("insertion de donnée a ".now(). " est l'instance est ".$this);
    }

    // generate reference
    public function getReference(){
       return rand();
    }

    public function attributeNoteToEleve($noteId = null){
    }
    
    // send sms parent
    /*public function afterSave(){
        $sms = new Sms;
        $classeselves = ClasseEleveModel::where('classe_id', $this->classe_id)->get();
        foreach($classeselves as $classeeleve){
            $eleve = EleveModel::where('id', $classeeleve->eleve_id)->first();
            if($eleve){
                // $user = User::where('parenteleve_id', $eleve->parent_id)->first();
                $parent = ParentModel::find($eleve->parent_id);
                if($parent){
                    $body = "Une note a été crée";
                    $sms->send($parent->tel, $parent, $eleve, $body);
                }
            }
        }
    }*/
}
