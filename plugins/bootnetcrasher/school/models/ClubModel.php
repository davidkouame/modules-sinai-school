<?php namespace BootnetCrasher\School\Models;

use Model;

/**
 * Model
 */
class ClubModel extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];


    /**
     * @var string The database table used by the model.
     */
    public $table = 'bootnetcrasher_school_club';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    public $attachOne = [
        'logo' => \System\Models\File::class
    ];
}
