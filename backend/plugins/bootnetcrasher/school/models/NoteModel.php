<?php namespace BootnetCrasher\School\Models;

use Model;

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
        'matiere' => ['BootnetCrasher\School\Models\MatiereModel', 'key' => 'matiere_id', 'otherKey' => 'id']
    ];
    
    public $hasMany = [
        'elevesnotes' => [
            'bootnetcrasher\school\models\noteeleve',
            'key' => 'eleve_id'
            ]
        ];

    public $belongsToMany = [
        'eleves' => [
            'bootnetcrasher\school\models\elevemodel',
            'table' => 'bootnetcrasher_school_note_eleve',
            'key' => 'eleve_id',
            'otherKey' => 'note_id'
        ]
    ];

    public function beforeCreate()
    {
        $this->reference = $this->getReference();
    }

    public function afterSave(){
        // dd($this->id);
    }

    // generate reference
    public function getReference(){
       return rand();
    }

    public function attributeNoteToEleve($noteId = null){

    }
}
