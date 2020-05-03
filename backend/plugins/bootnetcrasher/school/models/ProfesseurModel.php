<?php namespace BootnetCrasher\School\Models;

use Model;

/**
 * Model
 */
class ProfesseurModel extends Model
{
    use \October\Rain\Database\Traits\Validation;

    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];


    /**
     * @var string The database table used by the model.
     */
    public $table = 'bootnetcrasher_school_professeur';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    public $attachOne = [
        'logo' => \System\Models\File::class
    ];

    public $hasOne = [
        'users' => ['RainLab\User\Models\User', 'key' => 'professeur_id']
      ];

    public function getUsernameAttribute($value)
    {
        $professeur = \RainLab\User\Models\User::where('professeur_id', $this->id)->first();
        return $professeur ? $professeur->name : null;
    }

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

    /*
      Scope eleves
    */

    public function beforeCreate()
    {
        $this->reference = $this->getReference();
    }

    /*public function beforeUpdate(){
        // todo update reference if reference empty
        dd($this->reference);
        if(!$this->reference)
            $this->reference = $this->getReference();
    }*/

    // generate matricule
    public function getReference(){
        return rand();
    }
      
}
