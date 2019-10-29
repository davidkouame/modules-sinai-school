<?php namespace BootnetCrasher\School\Models;

use Model;

/**
 * Model
 */
use BootnetCrasher\School\Models\ClasseMatiereModel;
use BootnetCrasher\School\Models\EleveModel;
use DB;
use Illuminate\Support\Collection;

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

    /*public function eleves(){
        try{
            $elevesId = DB::table('bootnetcrasher_school_classe_eleve')
                                        ->where('classe_id', $this->id)
                                        ->select('eleve_id')
                                        ->get();
            $eleves = new Collection;
            $elevesId->each(function($e) use($eleves){
                $eleves->push(EleveModel::find($e->eleve_id));
            });
            return $eleves;
        }catch(Execption $e){
            $nameFile = dirname(__FILE__);
            trace_log("NameFile : ".$nameFile."Erreur lors de la recuperation des élèves, error : ".$e->getMessage());
            return null;
        }
    }*/
}
