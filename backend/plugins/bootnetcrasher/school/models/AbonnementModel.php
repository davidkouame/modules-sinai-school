<?php namespace BootnetCrasher\School\Models;

use Bootnetcrasher\School\Classes\Sms;
use Model;
use Mail;

/**
 * Model
 */
class AbonnementModel extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];


    /**
     * @var string The database table used by the model.
     */
    public $table = 'bootnetcrasher_school_abonnement';

    public $belongsTo = [
        "packabonnement" => ["BootnetCrasher\Parametrage\Models\PackAbonnementModel", "key" => "pack_abonnement_id", "otherKey" => "id"],
        "parent" => ["BootnetCrasher\School\Models\ParentModel", "key" => "parent_id", "otherKey" => "id"],
        "anneescolaire" => ["BootnetCrasher\School\Models\AnneeScolaireModel", "key" => "annee_scolaire_id", "otherKey" => "id"],
    ];

    public $hasMany = [
        'abonnementeleve' => ['BootnetCrasher\School\Models\AbonnementEleveModel', 'key' => 'abonnement_id', 'otherKey' => 'id'],
    ];

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    public function beforeCreate()
    {
        $this->reference = $this->getReference();

    }

    public function afterCreate(){
        $this->sendSmsMessage($this->id);
    }

    public function sendSmsMessage($abonnement_id){
        try{
            $sms = new Sms();
            $body = "Mes félicitations, votre abonnement à Ayauka a été éffectué avec succès . Ayauka vous remercie pour votre fidélité .";
            $abonnement = AbonnementModel::find($abonnement_id);
            $sms->sendParentForAbonnementQueue($this->parent, $body, $abonnement);
            trace_log("Envoi de sms au parent lors de la création d'un abonnement ");
        }catch (\Exception $ex){
            // trace_log("message : ".$ex->getMessage().", trace log".$ex->getTrace());
            trace_log("message : ".$ex->getMessage());
        }
    }

    // Send Email
    public function sendEmailMessage($abonnement_id){
        try{
            $body = "Mes félicitations, votre abonnement à Ayauka a été éffectué avec succès . Ayauka vous remercie pour votre fidélité .";
            $email = $this->parent->email;
            Mail::queue('school::mail.after.created.abonnement', [], function($message) use($email){
                $message->to($email, 'Admin Person');
                $message->subject('This is a reminder');
            });
            trace_log("Envoi de sms au parent lors de la création d'un abonnement ");
        }catch (\Exception $ex){
            // trace_log("message : ".$ex->getMessage().", trace log".$ex->getTrace());
            trace_log("message : ".$ex->getMessage());
        }
    }

    // generate matricule
    public function getReference(){
        return rand();
    }
}
