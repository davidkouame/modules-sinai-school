<?php namespace BootnetCrasher\School\Models;

use Model;
use Bootnetcrasher\School\Jobs\BillanAnnuelleJob;
use Queue;

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
        'typeanneescolaire' => ['BootnetCrasher\School\Models\TypeAnneeScolaireModel', 'key' => 'type_annee_scolaire_id', 'otherKey' => 'id'],
    ];

    /*public function afterUpdate(){
         if($this->validated_at)
            Queue::push(BillanAnnuelleJob::class, ["annee_scolaire_id" => $this->id]);
    }*/
}
