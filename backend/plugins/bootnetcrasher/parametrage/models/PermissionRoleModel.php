<?php namespace BootnetCrasher\Parametrage\Models;

use Model;

/**
 * Model
 */
class PermissionRoleModel extends Model
{
    use \October\Rain\Database\Traits\Validation;
    

    /**
     * @var string The database table used by the model.
     */
    public $table = 'bootnetcrasher_parametrage_permissions_roles';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    public $belongsTo = [
        'permission' => ['BootnetCrasher\Parametrage\Models\PermissionModel', 'key' => 'permission_id', 'otherKey' => 'id'],
        'role' => ['BootnetCrasher\Parametrage\Models\Role', 'key' => 'role_id', 'otherKey' => 'id'],
    ];
}
