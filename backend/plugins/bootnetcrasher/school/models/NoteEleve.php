<?php

namespace BootnetCrasher\School\Models;

use Model;
use Bootnetcrasher\School\Classes\Sms;
use BootnetCrasher\School\Models\ParentModel;
use BootnetCrasher\School\Models\EleveModel;
use Queue;

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
    
    public function afterCreate(){
        if($this->valeur){
            $sms = new Sms;
            $eleve = EleveModel::find($this->eleve_id);
            if($eleve){
                $parent = ParentModel::find($eleve->parent_id);
                if($parent){
                    $body = $eleve->name . " a obtenu ".$this->valeur." en ".$this->matiere->libelle;
                    $sms->send($parent->tel, $parent->user, $body);
                }
            }
            Queue::push(CalculMoyenneJob::class, ''); 
        }
    }
    
    public function beforeUpdate(){
        if($this->valeur){
            $sms = new Sms;
            $eleve = EleveModel::find($this->eleve_id);
            if($eleve){
                $parent = ParentModel::find($eleve->parent_id);
                if($parent){
                    $body = $eleve->name . " a obtenu ".$this->valeur." en ".
                            $this->note->matiere->libelle;
                    $sms->send($parent->tel, $parent, $eleve, $body);
                }
            }
            Queue::push(CalculMoyenneJob::class, ''); 
        }
    }


    /*public function afterUpdate(){
        if($this->valeur){
            $sms = new Sms;
            $eleve = EleveModel::find($this->eleve_id);
            if($eleve){
                dd($eleve);
                $parent = ParentModel::find($eleve->parent_id);
                if($parent){
                    // $body = $eleve->name . " a obtenu ".$this->valeur." en ".$this->matiere->libelle;
                    $body = $eleve->name . " a obtenu ".$this->valeur." en ";
                    $sms->send($parent->tel, $parent, $eleve, $body);
                }
            }  
        }
    }*/
}
