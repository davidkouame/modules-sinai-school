<?php namespace BootnetCrasher\School\Controllers;

use Backend\Classes\Controller;
use BackendMenu;
use BootnetCrasher\School\Models\ActualiteModel;

class ActualiteController extends Controller
{
    public $implement = [        'Backend\Behaviors\ListController',        'Backend\Behaviors\FormController'    ];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';

    public function __construct()
    {
        parent::__construct();
    }
    
    public function onPublier(){
        try{
            $actualitesId = post("checked");
            foreach($actualitesId as $actualiteId){
                $actualite = ActualiteModel::find($actualiteId);
                $actualite->published_at = now();
                $actualite->save();
            }
            \Flash::success("La publication des enregistrements a été effectuée avec succès !");
            return \Redirect::refresh();
        } catch (Exception $ex) {
            trace_log("Une erreur s'est produite lors de la publication des "
                    . "actualites, raison :".$ex->getMessage());
        }
    }

    public function listExtendQuery($query,$id)
    {
        $query->orderBy('id', 'desc');
    }
}
