<?php namespace BootnetCrasher\School\Controllers;

use Backend\Classes\Controller;
use BackendMenu;
use Backend;
use Redirect;
use Flash;
use \BootnetCrasher\School\Models\OrganigrameModel;

class OrganigrameController extends Controller
{
    public $implement = [        'Backend\Behaviors\ListController',        'Backend\Behaviors\FormController',        'Backend\Behaviors\ReorderController'    ];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';
    public $reorderConfig = 'config_reorder.yaml';

    public function __construct()
    {
        parent::__construct();
    }
    
    /*public function onSaveExtend($id = null){
        $data = post();
        $organigrameModel = $id != null ? OrganigrameModel::find($id) : new OrganigrameModel();
        $isClose = isset($data['close']) ? $data['close'] : 0;
        $organigrameModel->libelle = $data['OrganigrameModel']['libelle'];
        $organigrameModel->parent_organigrame_id = $data['OrganigrameModel']['organigrame'];
        $organigrameModel->niveau = $data['OrganigrameModel']['niveau'];
        $organigrameModel->save();
        Flash::success("L'enregistrement de l'organigrame s'est termine avec success");
        if($isClose == 1){
            return Redirect::to(Backend::url('bootnetcrasher/school/organigramecontroller')); ;
        }else{
            return Redirect::to(Backend::url('bootnetcrasher/school/organigramecontroller/update/'.$organigrameModel->id));
        }
    }*/
}
