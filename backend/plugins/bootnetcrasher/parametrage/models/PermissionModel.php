<?php namespace BootnetCrasher\Parametrage\Models;

use Model;

/**
 * Model
 */
class PermissionModel extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];


    /**
     * @var string The database table used by the model.
     */
    public $table = 'bootnetcrasher_parametrage_permission';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    public $belongsTo = [
        'permissionmenu' => ['BootnetCrasher\Parametrage\Models\PermissionMenuModel', 'key' => 'permission_menu_id', 'otherKey' => 'id']
    ];
}
