<?php namespace BootnetCrasher\School\Models;

use Model;

/**
 * Model
 */
class EleveModel extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];


    /**
     * @var string The database table used by the model.
     */
    public $table = 'bootnetcrasher_school_eleve';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];
    
    public $hasMany = [
        'eleves' => ['BootnetCrasher\School\Models\EleveModel'],
    ];

    public function beforeCreate()
    {
        $this->matricule = $this->getMatricule();
    }

    // generate matricule
    public function getMatricule(){
       return rand();
    }
}
