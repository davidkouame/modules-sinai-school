<?php namespace BootnetCrasher\School\Models;

use Model;

/**
 * Model
 */
class SchoolModel extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];


    /**
     * @var string The database table used by the model.
     */
    public $table = 'bootnetcrasher_school_school';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    public $belongsTo = [
        'pays' => ['BootnetCrasher\Parametrage\Models\PaysModel', 'key' => 'pays_id', 'otherKey' => 'id'],
    ];
}
