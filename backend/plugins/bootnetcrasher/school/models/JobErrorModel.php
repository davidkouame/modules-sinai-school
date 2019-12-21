<?php namespace BootnetCrasher\School\Models;

use Model;

/**
 * Model
 */
class JobErrorModel extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    // use \October\Rain\Database\Traits\SoftDelete;

    // protected $dates = ['deleted_at'];


    /**
     * @var string The database table used by the model.
     */
    public $table = 'failed_jobs';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];
}
