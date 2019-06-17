<?php namespace BootnetCrasher\Slideshow\Models;

use Model;

/**
 * Model
 */
class SlideShowModel extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];


    /**
     * @var string The database table used by the model.
     */
    public $table = 'bootnetcrasher_slideshow_slideshow';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    public $attachOne = [
        'slide' => \System\Models\File::class
    ];
}
