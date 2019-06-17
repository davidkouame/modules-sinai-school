<?php namespace BootnetCrasher\School\Models;

use Model;

/**
 * Model
 */
class ExamenModel extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];


    /**
     * @var string The database table used by the model.
     */
    public $table = 'bootnetcrasher_school_examen';

    /**
     * @var array Validation rules
     */
    public $rules = [
        "name" => "required|max:150",
        "description" => "required|max:400",
        "datedebut" => "required",
        "datefin" => "required"
    ];

    public $attachOne = [
        'resultats' => \System\Models\File::class,
        'sujets' => \System\Models\File::class,
        'corrections' => \System\Models\File::class,
    ];
}
