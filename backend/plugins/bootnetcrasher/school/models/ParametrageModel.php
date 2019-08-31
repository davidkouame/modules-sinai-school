<?php namespace BootnetCrasher\School\Models;

use Model;

/**
 * Model
 */
class ParametrageModel extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];


    /**
     * @var string The database table used by the model.
     */
    public $table = 'bootnetcrasher_school_parametrage';

    /**
     * @var array Validation rules
     */
    public $rules = [
        "key" => "required|max:100"
    ];

    public $attachOne = [
        'logo' => \System\Models\File::class
    ];
}
