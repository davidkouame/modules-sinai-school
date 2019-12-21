<?php namespace BootnetCrasher\School\Models;

use Model;

/**
 * Model
 */
class MoyenneModel extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];


    /**
     * @var string The database table used by the model.
     */
    public $table = 'bootnetcrasher_school_moyenne';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    public $belongsTo = [
        'eleve' => ['BootnetCrasher\School\Models\EleveModel', 'key' => 'eleve_id', 'otherKey' => 'id'],
        'typemoyenne' => ['BootnetCrasher\School\Models\TypeMoyenneModel', 'key' => 'type_moyenne_id', 'otherKey' => 'id'],
        'matiere' => ['BootnetCrasher\School\Models\MatiereModel', 'key' => 'matiere_id', 'otherKey' => 'id'],
        'sectionanneescolaire' => ['BootnetCrasher\School\Models\SectionAnneeScolaireModel', 'key' => 'section_annee_scolaire_id', 'otherKey' => 'id'],
        'anneescolaire' => ['BootnetCrasher\School\Models\AnneeScolaireModel', 'key' => 'annee_scolaire_id', 'otherKey' => 'id']
    ];
    
    public $hasMany = [
        'classes' => ['BootnetCrasher\School\Models\ClasseMatiereModel', 'key' => 'classe_id', 'otherKey' => 'classe_id']
    ];

    public function getCoefficientMoyenneMatiereFormatAttribute()
    {
        return $this->valeur * $this->coefficient_matiere."/".$this->coefficient_matiere*20;
    }

    public function getCoefficientMoyenneSectionFormatAttribute()
    {

        if($this->sectionanneescolaire){
            $coefficient = $this->sectionanneescolaire->coefficient;
            return $this->valeur * $coefficient."/".$coefficient*20;
        }else{
            return null;
        }

    }

    public function getCoefficientSectionAttribute(){
        return $this->sectionanneescolaire ? $this->sectionanneescolaire->coefficient : null;
    }

    public function getValeurFormatAttribute($valeur){
        return $this->valeur."/20";
    }
}
