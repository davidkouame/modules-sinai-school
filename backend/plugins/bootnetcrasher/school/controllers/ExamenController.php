<?php namespace BootnetCrasher\School\Controllers;

use Backend\Classes\Controller;
use BootnetCrasher\School\Models\ExamenModel;
use BackendMenu;

class ExamenController extends Controller
{
    public $implement = [        'Backend\Behaviors\ListController',        'Backend\Behaviors\FormController',        'Backend\Behaviors\ReorderController'    ];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';
    public $reorderConfig = 'config_reorder.yaml';

    public function __construct()
    {
        parent::__construct();
    }
    
    public function onPublier(){
        try{
            $examensId = post("checked");
            foreach($examensId as $examenId){
                $examen = ExamenModel::find($examenId);
                $examen->published_at = now();
                $examen->save();
            }
            \Flash::success("La publication des enregistrements a été effectuée avec succès !");
            return \Redirect::refresh();
        } catch (Exception $ex) {
            trace_log("Une erreur s'est produite lors de la publication des "
                    . "examens, raison :".$ex->getMessage());
        }
    }

    public function listExtendQuery($query,$id)
    {
        $query->orderBy('id', 'desc');
    }
}
