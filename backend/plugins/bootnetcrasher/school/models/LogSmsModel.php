<?php namespace BootnetCrasher\School\Models;

use Model;

/**
 * Model
 */
class LogSmsModel extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];


    /**
     * @var string The database table used by the model.
     */
    public $table = 'bootnetcrasher_school_log_sms';
    
    public $belongsTo = [
        //'user' => ['RainLab\User\Models\User', 'key' => 'user_id', 'otherKey' => 'id'],
        'parent' => ['RainLab\User\Models\User', 'key' => 'user_id', 'otherKey' => 'parenteleve_id'],
    ];

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];
}
