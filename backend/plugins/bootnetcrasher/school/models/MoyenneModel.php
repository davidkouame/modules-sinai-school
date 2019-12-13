<?php namespace BootnetCrasher\School\Models;

use Model;

/**
 * Model
 */
class MoyenneModel extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];


    /**
     * @var string The database table used by the model.
     */
    public $table = 'bootnetcrasher_school_moyenne';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    public $belongsTo = [
        'eleve' => ['BootnetCrasher\School\Models\EleveModel', 'key' => 'eleve_id', 'otherKey' => 'id'],
        'typemoyenne' => ['BootnetCrasher\School\Models\TypeMoyenneModel', 'key' => 'type_moyenne_id', 'otherKey' => 'id'],
        'matiere' => ['BootnetCrasher\School\Models\MatiereModel', 'key' => 'matiere_id', 'otherKey' => 'id'],
        'sectionanneescolaire' => ['BootnetCrasher\School\Models\SectionAnneeScolaireModel', 'key' => 'section_annee_scolaire_id', 'otherKey' => 'id'],
        'anneescolaire' => ['BootnetCrasher\School\Models\AnneeScolaireModel', 'key' => 'annee_scolaire_id', 'otherKey' => 'id']
    ];
    
    public $hasMany = [
        'classes' => ['BootnetCrasher\School\Models\ClasseMatiereModel', 'key' => 'classe_id', 'otherKey' => 'classe_id']
    ];
}
