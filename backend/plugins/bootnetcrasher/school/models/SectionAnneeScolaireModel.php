<?php namespace BootnetCrasher\School\Models;

use Model;
use Queue;
use Bootnetcrasher\School\Jobs\MoyenneJob;

/**
 * Model
 */
class SectionAnneeScolaireModel extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];


    /**
     * @var string The database table used by the model.
     */
    public $table = 'bootnetcrasher_school_section_annee_scolaire';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];
    
    public $belongsTo = [
        'anneescolaire' => ['BootnetCrasher\School\Models\AnneeScolaireModel', 'key' => 'annee_scolaire_id', 'otherKey' => 'id'],
    ];

    public function afterSave(){
        trace_log("after save");
        if($this->validated_at)
            Queue::push(MoyenneJob::class, ["section_annee_scolaire_id" => $this->id]);
    }
}
