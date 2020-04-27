<?php namespace BootnetCrasher\Parametrage\Models;

use Model;

/**
 * Model
 */
class Role extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];


    /**
     * @var string The database table used by the model.
     */
    public $table = 'bootnetcrasher_parametrage_role';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    /*public $belongsToMany = [
        'groups' => [UserGroup::class, 'table' => 'users_groups']
    ];

    public $belongsToMany = [
        'permissions' => ['BootnetCrasher\Parametrage\Models\Role', 'key' => 'role_id', 'otherKey' => 'id'],
    ];*/
}
