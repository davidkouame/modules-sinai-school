<?php namespace BootnetCrasher\School\Models;

use Model;
use Illuminate\Support\Facades\DB;

/**
 * Model
 */
class ParentModel extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];


    /**
     * @var string The database table used by the model.
     */
    public $table = 'bootnetcrasher_school_parent';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];
    
    public $hasOne = [
      'users' => ['RainLab\User\Models\User', 'key' => 'parenteleve_id'],
      'user' => ['RainLab\User\Models\User', 'key' => 'parenteleve_id']  
    ];

    public $hasMany = [
        'eleves' => ['BootnetCrasher\School\Models\EleveModel', 'key' => 'parent_id', 'otherKey' => 'id'],
    ];

    public function beforeCreate()
    {
        $this->matricule = $this->getMatricule();
    }

    /*public function beforeSave(){
        $parentmodel = ParentModel::find($this->id);
        dd($this);
    }*/

    public function afterSave(){
        $parentmodel = ParentModel::find($this->id);
        if($parentmodel){
            DB::table('bootnetcrasher_school_parent')
              ->where('id', $this->id)
              ->update([
                        'name' => $this->user->name,
                        'surname' => $this->user->surname,
                        'email' => $this->user->email
                ]);
        }
    }

    // generate matricule
    public function getMatricule(){
       return rand();
    }
}
