<?php namespace BootnetCrasher\School\Models;

use Model;

/**
 * Model
 */
class AbonnementEleveModel extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];


    /**
     * @var string The database table used by the model.
     */
    public $table = 'bootnetcrasher_school_abonnement_eleve';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    public $belongsTo = [
        "abonnement" => ["BootnetCrasher\School\Models\AbonnementModel", "key" => "abonnement_id", "otherKey" => "id"],
        "eleve" => ["BootnetCrasher\School\Models\EleveModel", "key" => "eleve_id", "otherKey" => "id"],
        "anneescolaire" => ["BootnetCrasher\School\Models\AnneeScolaireModel", "key" => "annee_scolaire_id", "otherKey" => "id"],
    ];
}
