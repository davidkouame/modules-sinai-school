<?php namespace BootnetCrasher\School\Models;

use Model;

/**
 * Model
 */
class JobSuccessModel extends Model
{
    use \October\Rain\Database\Traits\Validation;
    

    /**
     * @var string The database table used by the model.
     */
    public $table = 'success_jobs';
    
    public $timestamps = false;

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];
}
