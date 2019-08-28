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
        'classe' => ['BootnetCrasher\School\Models\ClasseModel', 'key' => 'classe_id', 'otherKey' => 'id'],
    ];
}
