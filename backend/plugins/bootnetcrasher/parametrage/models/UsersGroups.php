<?php namespace BootnetCrasher\Parametrage\Models;

use Model;

/**
 * Model
 */
class UsersGroups extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];


    /**
     * @var string The database table used by the model.
     */
    public $table = 'bootnetcrasher_parametrage_users_groups';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    public $belongsTo = [
        'user' => ['RainLab\User\Models\User', 'key' => 'user_id', 'otherKey' => 'id'],
        'group' => ['BootnetCrasher\Parametrage\Models\UserGroup', 'key' => 'group_id', 'otherKey' => 'id'],
    ];
}
