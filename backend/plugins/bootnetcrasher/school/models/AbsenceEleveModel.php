<?php namespace BootnetCrasher\School\Models;

use Model;

/**
 * Model
 */
class AbsenceEleveModel extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];


    /**
     * @var string The database table used by the model.
     */
    public $table = 'bootnetcrasher_school_absence';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    public $belongsTo = [
        "raisonabsence" => ["BootnetCrasher\Parametrage\Models\RaisonAbsenceModel", "key" => "raisonabsence_id", "otherKey" => "id"],
        "eleve" => ["BootnetCrasher\School\Models\EleveModel", "key" => "eleve_id", "otherKey" => "id"],
    ];
}
