<?php namespace BootnetCrasher\School\Models;

use Model;

/**
 * Model
 */
class ClasseModel extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];


    /**
     * @var string The database table used by the model.
     */
    public $table = 'bootnetcrasher_school_classe';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    public $belongsTo = [
        'niveau' => ['BootnetCrasher\School\Models\NiveauClasseModel', 'key' => 'niveau_id', 'otherKey' => 'id'],
        'serie' => ['BootnetCrasher\School\Models\SerieClasseModel', 'key' => 'serie_id', 'otherKey' => 'id'],
    ];

    public $attachOne = [
        'emploisdutemps' => \System\Models\File::class
    ];
}
