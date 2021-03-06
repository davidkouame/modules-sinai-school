<?php namespace BootnetCrasher\School\Controllers;

use Backend\Classes\Controller;
use BackendMenu;
use Bootnetcrasher\School\Classes\Sms;
use BootnetCrasher\School\Models\EleveModel;
use BootnetCrasher\School\Models\ParentModel;
use BootnetCrasher\School\Models\MoyenneModel;
use Illuminate\Support\Facades\Redirect;
use Backend;
use DB;
use October\Rain\Support\Facades\Flash;

class MoyenneAnnuelleController extends Controller
{
    public $implement = [        'Backend\Behaviors\ListController',        'Backend\Behaviors\FormController'    ];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('BootnetCrasher.School', 'moyennes');
    }
    
    public function listExtendQuery($query,$id)
    {
        $query->where('type_moyenne_id', 1)->orderBy('id', 'desc');
    }
    
    // validation d'une moyenne
    public function onValidate() {
        foreach (post("checked") as $id) {
            $moyenne = MoyenneModel::find($id);
            if(!$moyenne->validated_at){
                $moyenne->validated_at = now();
                $moyenne->save();
                $this->SendSms($moyenne);

            }
        }
        if(count(post("checked")) > 1)
            Flash::warning("Les moyennes ont été validé avec succès.");
        else
            Flash::success("La moyenne a été validé avec succès.");
        return Redirect::to(Backend::url('bootnetcrasher/school/moyenneannuellecontroller'));
    }
    
    // send sms
    public function SendSms($moyenne) {
        if ($moyenne) {
            $sms = new Sms;
            $eleve = EleveModel::find($moyenne->eleve_id);
            if ($eleve) {
                $parent = ParentModel::find($eleve->parent_id);
                if ($parent) {
                    $body = $eleve->name . " a obtenu " . $this->valeur . " en " .
                            $moyenne->anneescolaire->libelle;
                    $sms->send($parent->tel, $parent, $eleve, $body);
                }
            }
        }
    }
}
