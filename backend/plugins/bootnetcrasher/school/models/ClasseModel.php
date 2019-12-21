<?php namespace BootnetCrasher\School\Models;

use Model;

/**
 * Model
 */
use BootnetCrasher\School\Models\ClasseMatiereModel;
use BootnetCrasher\School\Models\EleveModel;
use DB;
use Illuminate\Support\Collection;
use BootnetCrasher\School\Models\ClasseEleveModel;

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
                        "libelle" => "required",
                        "niveau" => "required",
                        "emploisdutemps" => "required"
    ];

    public $belongsTo = [
        'niveau' => ['BootnetCrasher\School\Models\NiveauClasseModel', 'key' => 'niveau_id', 'otherKey' => 'id'],
        'serie' => ['BootnetCrasher\School\Models\SerieClasseModel', 'key' => 'serie_id', 'otherKey' => 'id'],
        'professeurprincipal' => ['BootnetCrasher\School\Models\ProfesseurModel', 'key' => 'professeur_principal_id', 'otherKey' => 'id'],
    ];

    public $attachOne = [
        'emploisdutemps' => \System\Models\File::class
    ];

    /* public $belongsToMany = [
        'matieres' => [
            'bootnetcrasher\school\models\matieremodel',
            'table' => 'bootnetcrasher_school_classe_matiere',
            'key' => 'matiere_id',
            'otherKey' => 'classe_id'
        ]
    ]; */

    public $hasMany = [
        'classematiere' => ['BootnetCrasher\School\Models\ClasseMatiereModel', 'key' => 'classe_id', 'otherKey' => 'id'],
        'eleves' => ['BootnetCrasher\School\Models\ClasseEleveModel', 'key' => 'classe_id', 'otherKey' => 'id'],
    ];

    /* recuperation de tous les eleves d'une classe
     * return array EleveModel
     * int $anee_scolaire_id
     */
    public function allEleves   ($annee_scolaire = null){
        $eleves = new Collection;
        try{
            // trace_log("l'id de la classe est ".$this->id);
            $classeseleves = ClasseEleveModel::where('classe_id', $this->id);
            if($annee_scolaire)
                $classeseleves->where('annee_scolaire_id', $annee_scolaire);
            $classeseleves = $classeseleves->get();
            $classeseleves->each(function($element) use($eleves){
                $eleves->push($element->eleve);
            });
        }catch(\Execption $e){
            trace_log($e);
        }
        return $eleves;
    }
}
