<?php namespace BootnetCrasher\School\Models;

use Model;

/**
 * Model
 */
class MatiereModel extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];


    /**
     * @var string The database table used by the model.
     */
    public $table = 'bootnetcrasher_school_matiere';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];
    
    public $belongsTo = [
        'typematiere' => ['BootnetCrasher\School\Models\TypeMatiere', 'key' => 'typematiere_id', 'otherKey' => 'id']
    ];

    public $hasMany = [
        'classematiere' => ['BootnetCrasher\School\Models\ClasseMatiereModel', 'key' => 'matiere_id', 'otherKey' => 'id']
    ];
}
