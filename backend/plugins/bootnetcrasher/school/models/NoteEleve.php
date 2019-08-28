<?php

namespace BootnetCrasher\School\Models;

use Model;

/**
 * Model
 */
class NoteEleve extends Model {
    use \October\Rain\Database\Traits\Validation;

    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];


    /**
     * @var string The database table used by the model.
     */
    public $table = 'bootnetcrasher_school_note_eleve';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    public $belongsTo = [
    'note' => ['BootnetCrasher\School\Models\NoteModel', 'key' => 'note_id', 'otherkey' => 'id'],
    'eleve' => ['BootnetCrasher\School\Models\EleveModel', 'key' => 'eleve_id', 'otherKey' => 'id']
    ];
}
