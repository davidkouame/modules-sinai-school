<?php namespace BootnetCrasher\School\Models;

use Model;

/**
 * Model
 */
class ClasseMatiereModel extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];


    /**
     * @var string The database table used by the model.
     */
    public $table = 'bootnetcrasher_school_classe_matiere';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    public $belongsTo = [
        'matiere' => ['BootnetCrasher\School\Models\MatiereModel', 'key' => 'matiere_id', 'otherKey' => 'id'],
        'anneescolaire' => ['BootnetCrasher\School\Models\AnneeScolaireModel', 'key' => 'annee_scolaire_id', 'otherKey' => 'id'],
        'classe' => ['BootnetCrasher\School\Models\ClasseModel', 'key' => 'classe_id', 'otherKey' => 'id'],
        'professeur' => ['BootnetCrasher\School\Models\ProfesseurModel', 'key' => 'professeur_id', 'otherKey' => 'id'],
    ];

    /*public $belongsToMany = [
        'classeseleves' => ['BootnetCrasher\School\Models\ClasseEleveModel', 'key' => 'classe_id', 'otherKey' => 'id']
    ];*/

    public $hasMany = [
        'classeseleves' => ['BootnetCrasher\School\Models\ClasseEleveModel', 'key' => 'classe_id', 'otherKey' => 'id']
    ];
}
