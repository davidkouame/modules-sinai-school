<?php namespace BootnetCrasher\School\Models;

use Model;
use BootnetCrasher\School\Models\AnneeScolaireModel;

/**
 * Model
 */
class SouscriptionSchoolModel extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];


    /**
     * @var string The database table used by the model.
     */
    public $table = 'bootnetcrasher_school_souscription_school';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    public $belongsTo = [
        'school' => ['BootnetCrasher\School\Models\SchoolModel', 'key' => 'school_id', 'otherKey' => 'id'],
        'anneescolaire' => ['BootnetCrasher\School\Models\AnneeScolaireModel', 'key' => 'annee_scolaire_id', 'otherKey' => 'id'],
        'typesouscription' => ['BootnetCrasher\Parametrage\Models\TypeSouscriptionModel', 'key' => 'type_souscription_id', 'otherKey' => 'id'],
    ];

    public function afterSave(){
        $anneeScolaire = AnneeScolaireModel::find($this->annee_scolaire_id);
        if($anneeScolaire){
            $anneeScolaire->school_id = $this->id;
            $anneeScolaire->save();
        }
    }
}
