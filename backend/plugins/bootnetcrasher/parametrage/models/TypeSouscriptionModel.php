<?php namespace BootnetCrasher\Parametrage\Models;

use Model;

/**
 * Model
 */
class TypeSouscriptionModel extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];


    /**
     * @var string The database table used by the model.
     */
    public $table = 'bootnetcrasher_parametrage_type_souscription';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];
}
