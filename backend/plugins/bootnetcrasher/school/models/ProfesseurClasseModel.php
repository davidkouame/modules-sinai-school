<?php namespace BootnetCrasher\School\Models;

use Model;

/**
 * Model
 */
class ProfesseurClasseModel extends Model
{
    use \October\Rain\Database\Traits\Validation;

    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];

    // public $table = 'bootnetcrasher_school_classe_anneescolaire_matiere';
    public $table = 'bootnetcrasher_school_classe_matiere';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    public $belongsTo = [
        "classe" => ["BootnetCrasher\School\Models\ClasseModel", "key" => "classe_id", "otherKey" => "id"],
        "matiere" => ["BootnetCrasher\School\Models\MatiereModel", "key" => "matiere_id", "otherKey" => "id"],
        "professeur" => ["BootnetCrasher\School\Models\ProfesseurModel", "key" => "professeur_id", "otherKey" => "id"],
    ];
}
