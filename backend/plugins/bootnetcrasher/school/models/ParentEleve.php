<?php namespace BootnetCrasher\School\Models;

use Model;

/**
 * Model
 */
class ParentEleve extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];


    /**
     * @var string The database table used by the model.
     */
    public $table = 'bootnetcrasher_school_parent';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];
}
