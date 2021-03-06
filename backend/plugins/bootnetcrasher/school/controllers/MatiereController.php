<?php namespace BootnetCrasher\School\Controllers;

use Backend\Classes\Controller;
use BackendMenu;

class MatiereController extends Controller
{
    public $implement = [        'Backend\Behaviors\ListController',        'Backend\Behaviors\FormController'    ];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';

    public function __construct()
    {
        BackendMenu::setContext('BootnetCrasher.School', 'parametres', 'matieres');
        parent::__construct();
    }
    
    public function listExtendQuery($query,$id)
    {
        // $query->where('type_moyenne_id', 2);
        $query->orderBy('id', 'desc');
    }
}
