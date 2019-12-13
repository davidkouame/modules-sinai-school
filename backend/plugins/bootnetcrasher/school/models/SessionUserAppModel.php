<?php namespace BootnetCrasher\School\Models;

use Model;

/**
 * Model
 */
class SessionUserAppModel extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];


    /**
     * @var string The database table used by the model.
     */
    public $table = 'bootnetcrasher_school_session_user_app';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];
    
    public $belongsTo = [
        'user' => ['RainLab\User\Models\User', 'key' => 'user_id', 'otherKey' => 'id'],
        'anneescolaire' => ['BootnetCrasher\School\Models\AnneeScolaireModel', 'key' => 'annee_scolaire_id', 'otherKey' => 'id'],
    ];
}
