<?php namespace BootnetCrasher\School\Models;

use Model;

/**
 * Model
 */
class TypeMatiere extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];


    /**
     * @var string The database table used by the model.
     */
    public $table = 'bootnetcrasher_school_type_matiere';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];
}
