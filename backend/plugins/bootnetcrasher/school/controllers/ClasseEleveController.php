<?php namespace BootnetCrasher\School\Controllers;

use Backend\Classes\Controller;
use BackendMenu;

class ClasseEleveController extends Controller
{
    public $implement = [        'Backend\Behaviors\ListController',        'Backend\Behaviors\FormController'    ];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';

    public function __construct()
    {
        parent::__construct();
    }

    public function listExtendQuery($query, $id)
    {
        // dd($query->where('classe_id', 14)->get());
        // dd($query->distinct()->get(['id']));
        // $querClone = $query;
        // dd($querClone->get());
        // $query->groupBy('classe_id','annee_scolaire_id')->select('classe_id','annee_scolaire_id');
    }
}
