<?php namespace BootnetCrasher\School\Models;

use Model;

/**
 * Model
 */
class ParentEleveModel extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];


    /**
     * @var string The database table used by the model.
     */
    public $table = 'bootnetcrasher_school_parent_eleve';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    public $belongsTo = [
      'parent' => ['BootnetCrasher\School\Models\ParentModel', 'key' => 'parent_id', 'otherKey' => 'id'],
      'eleve' => ['BootnetCrasher\School\Models\EleveModel', 'key' => 'eleve_id', 'otherKey' => 'id']
    ];

    public function getParAttribute()
    {
        return "test";
    }
}
