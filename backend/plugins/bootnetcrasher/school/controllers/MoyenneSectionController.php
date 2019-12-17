<?php

namespace BootnetCrasher\School\Controllers;

use Backend\Classes\Controller;
use BackendMenu;
use Bootnetcrasher\School\Classes\Sms;
use BootnetCrasher\School\Models\EleveModel;
use BootnetCrasher\School\Models\ParentModel;
use BootnetCrasher\School\Models\MoyenneModel;
use Illuminate\Support\Facades\Redirect;
use Backend;

class MoyenneSectionController extends Controller {

    public $implement = [ 'Backend\Behaviors\ListController', 'Backend\Behaviors\FormController'];
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';

    public function __construct() {
        parent::__construct();
        BackendMenu::setContext('BootnetCrasher.School', 'moyennes');
    }

    public function listExtendQuery($query, $id) {
        $query->where('type_moyenne_id', 3)->orderBy('id', 'desc');
    }

    // validation d'une moyenne
    public function onValidate() {
        foreach (post("checked") as $id) {
            $moyenne = MoyenneModel::find($id);
            $moyenne->validated_at = now();
            $moyenne->save();
            $this->SendSms($moyenne);
            return Redirect::to(Backend::url('bootnetcrasher/school/moyennesectioncontroller'));
        }
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
                            $moyenne->sectionanneescolaire->libelle;
                    $sms->send($parent->tel, $parent, $eleve, $body);
                }
            }
        }
    }
}
