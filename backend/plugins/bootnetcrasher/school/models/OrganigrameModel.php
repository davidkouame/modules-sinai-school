<?php namespace BootnetCrasher\School\Models;

use Model;

/**
 * Model
 */
class OrganigrameModel extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];


    /**
     * @var string The database table used by the model.
     */
    public $table = 'bootnetcrasher_school_organigrame';

    /**
     * @var array Validation rules
     */
    public $rules = [
        "niveau" => "required",
        "parent_organigrame_id" => "required",
        "libelle" => "required|max:100"
    ];
    
    public $belongsTo = [
        'organigrame' => ['\BootnetCrasher\School\Models\OrganigrameModel', 'key' => 'parent_organigrame_id', 'otherKey' => 'id']
    ];
    
    // permet de ramener un query des enfants
    public function scopeChildren($query){
        return $query->where('parent_organigrame_id', $this->id);
    }
    
    // permet de ramener une collection des enfants
    public function scopeGetChildren($query){
        return $query->where('parent_organigrame_id', $this->id)->get();
    }
}
