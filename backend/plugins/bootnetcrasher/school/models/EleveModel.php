<?php namespace BootnetCrasher\School\Models;

use Model;

/**
 * Model
 */
class EleveModel extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];
    
    protected $appends = ['classe_id', 'full_name'];


    /**
     * @var string The database table used by the model.
     */
    public $table = 'bootnetcrasher_school_eleve';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];
    
    public $hasOne = [
      'users' => ['RainLab\User\Models\User', 'key' => 'eleve_id'],
      'user' => ['RainLab\User\Models\User', 'key' => 'eleve_id']  
    ];
    
    protected $fillable = ['test'];

    public $belongsTo = [
        'parent' => ['BootnetCrasher\School\Models\ParentModel', 'key' => 'parent_id', 'otherKey' => 'id'],
    ];

    public $hasMany = [
        'classeseleves' => ['BootnetCrasher\School\Models\ClasseEleveModel', 'key' => 'eleve_id', 'otherKey' => 'id'],
        'noteseleves' => ['BootnetCrasher\School\Models\NoteEleve', 'key' => 'eleve_id', 'otherKey' => 'id'],
    ];

    public function beforeCreate()
    {
        $this->matricule = $this->getMatricule();
    }

    // generate matricule
    public function getMatricule(){
       return rand();
    }

    /*public function scopeParent($query){
        dd($query);
    }*/
    
    // get la classe de l'élève
    public function classe(){
        return $this->classeseleves ? $this->classeseleves[0] : null;
    }
    
    public function getClasseIdAttribute()
    {
        // dd($this->classeseleves);
        $classeeleve = ClasseEleveModel::where('eleve_id', $this->id)->first();
        return $classeeleve ? $classeeleve->classe_id : null;
    }

    public function getFullNameAttribute()
    {
        return "{$this->name} {$this->surname}";
    }
}
