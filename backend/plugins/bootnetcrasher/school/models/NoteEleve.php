<?php

namespace BootnetCrasher\School\Models;

use BootnetCrasher\School\Models\EleveModel;
use BootnetCrasher\School\Models\ParentModel;
use Model;
use Bootnetcrasher\School\Classes\Sms;
use Bootnetcrasher\School\Classes\Abonnement;
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

    public $belongsToMany = [
        // 'test' => ['BootnetCrasher\School\Models\NoteModel', 'key' => 'note_id', 'otherkey' => 'id']
        'test' => ['BootnetCrasher\School\Models\NoteModel',
            'table' => 'bootnetcrasher_school_note_eleve',
        'key' => 'note_id',
            'otherKey' => 'id']
    ];
    
    public function afterCreate(){
        try{
            /*if($this->valeur){
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
            }*/
        }catch(\Exception $e){
            trace_log($e->getTrace());
        }
    }
    
    /*public function afterUpdate(){
        try{
            if($this->valeur){
                $sms = new Sms;
                $eleve = EleveModel::find($this->eleve_id);
                if($eleve && Abonnement::hasAbonnement($eleve)){
                    $parent = Abonnement::getParentToAbonnement($eleve);
                    // $parent = ParentModel::find($eleve->parent_id);
                    if($parent){
                        $body = $eleve->name . " a obtenu ".$this->valeur." en ".
                                $this->note->matiere->libelle;
                        $sms->sendQueue($parent->tel, $body, $parent, $eleve);
                    }
                }
                // Queue::push(CalculMoyenneJob::class, ''); 
            }
        }catch(\Exception $e){
            trace_log("message : ".$e->getMessage().", trace :".$e->getTrace());
        }
    }*/


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

    // Send sms after set value note at student
    public function afterSave(){
        try{
            if($this->valeur){
                $sms = new Sms;
                $eleve = EleveModel::find($this->eleve_id);
                if($eleve && Abonnement::hasAbonnement($eleve)){
                    // $parent = ParentModel::find($eleve->parent_id);
                    $parent = Abonnement::getParentToAbonnement($eleve);
                    if($parent){
                        $body = $eleve->name.' '.$eleve->surname . " a obtenu ".$this->valeur.'/'.($this->note->coefficient*20)." en ".
                            $this->note->matiere->libelle;
                        $sms->sendQueue($parent->tel, $body, $parent, $eleve);
                    }
                }
                // Queue::push(CalculMoyenneJob::class, '');
            }
        }catch(\Exception $e){
            trace_log("message : ".$e->getMessage().", trace :".$e->getTrace());
        }
    }
}
