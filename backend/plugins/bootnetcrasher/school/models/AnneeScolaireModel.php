<?php namespace BootnetCrasher\School\Models;

use Model;

/**
 * Model
 */
class AnneeScolaireModel extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];


    /**
     * @var string The database table used by the model.
     */
    public $table = 'bootnetcrasher_school_annee_scolaire';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];
    
    public $belongsTo = [
        'typeanneescolaire' => ['BootnetCrasher\School\Models\TypeAnneeScolaireModel', 'key' => 'type_annnee_scolaire_id', 'otherKey' => 'id'],
    ];
}
