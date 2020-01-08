<?php namespace BootnetCrasher\School\Models;

use Bootnetcrasher\School\Classes\Sms;
use Model;

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
        $this->sendMessage($this->id);
    }

    public function sendMessage($abonnement_id){
        try{
            $sms = new Sms();
            $body = "Mes félicitations, votre abonnement à Ayauka a été éffectué avec succès . 
            Ayauka vous remercie pour votre fidélité .";
            $abonnement = AbonnementModel::find($abonnement_id);
            $sms->sendParentForAbonnement($this->parent, $body, $abonnement);
        }catch (\Exception $ex){
             trace_log("message : ".$ex->getMessage().", trace log".$ex->getTrace());
        }
    }

    // generate matricule
    public function getReference(){
        return rand();
    }
}