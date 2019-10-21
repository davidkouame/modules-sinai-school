<?php namespace BootnetCrasher\School\Models;

use Model;

/**
 * Model
 */
class ClasseEleveModel extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];


    /**
     * @var string The database table used by the model.
     */
    public $table = 'bootnetcrasher_school_classe_eleve';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    public $belongsTo = [
        'eleve' => ['BootnetCrasher\School\Models\EleveModel', 'key' => 'eleve_id', 'otherKey' => 'id'],
        'classe' => ['BootnetCrasher\School\Models\ClasseModel', 'key' => 'classe_id', 'otherKey' => 'id'],
    ];

}
