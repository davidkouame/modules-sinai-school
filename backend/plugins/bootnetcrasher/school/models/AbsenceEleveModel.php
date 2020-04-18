<?php

namespace BootnetCrasher\School\Models;

use Model;
use Bootnetcrasher\School\Classes\Sms;
use BootnetCrasher\School\Models\EleveModel;
use BootnetCrasher\School\Models\ParentModel;
use Bootnetcrasher\School\Classes\Abonnement;
use Mail;

/**
 * Model
 */
class AbsenceEleveModel extends Model {

    use \October\Rain\Database\Traits\Validation;

use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'bootnetcrasher_school_absence';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];
    public $belongsTo = [
        "raisonabsence" => ["BootnetCrasher\Parametrage\Models\RaisonAbsenceModel", "key" => "raisonabsence_id", "otherKey" => "id"],
        "eleve" => ["BootnetCrasher\School\Models\EleveModel", "key" => "eleve_id", "otherKey" => "id"],
    ];

    public function afterCreate() {
        $eleve = EleveModel::find($this->eleve_id);
        if ($eleve && Abonnement::hasAbonnement($eleve)) {
            // $parent = ParentModel::find($eleve->parent_id);
            $parent = Abonnement::getParentToAbonnement($eleve);
            if ($parent) {
                $body = $eleve->name .' '.$eleve->surname . " a été absent de " . date("H:i", strtotime($this->heure_debut_cours)) . " a " .
                    date("H:i", strtotime($this->heure_fin_cours))." le ".date("Y-m-d", strtotime($this->heure_debut_cours)).
                    " ; Raison : ".$this->raisonabsence->libelle;
                if($this->commentaire)
                    $body = $body . "; Description : ".$this->commentaire;
                
                // Send sms
                // $sms = new Sms;
                // $sms->sendQueue($parent->tel, $body, $parent);

                // Send Email
                $vars = [
                    'nameandsurname' => $eleve->name.' '.$eleve->surname , 
                    'heuredebut' => date("H:i", strtotime($this->heure_debut_cours)),
                    'heurefin' => date("H:i", strtotime($this->heure_fin_cours)),
                    'date' => date("Y-m-d", strtotime($this->heure_debut_cours)),
                    'raison' => $this->raisonabsence->libelle
                ];
                if($this->commentaire){
                    $vars['description'] = "; Description : ".$this->commentaire;
                }
                $email = $parent->email;
                Mail::queue('school::mail.after.created.absence', $vars, function($message) use($email){
                    $message->to($email, 'Admin Person');
                    $message->subject('This is a reminder');
                });
            }
        }
    }

}
