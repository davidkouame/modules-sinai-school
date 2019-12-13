<?php namespace BootnetCrasher\School\Controllers;

use Backend\Classes\Controller;
use BackendMenu;

class TypeAnneeScolaireController extends Controller
{
    public $implement = [        'Backend\Behaviors\ListController',        'Backend\Behaviors\FormController'    ];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';

    public function __construct()
    {
        BackendMenu::setContext('BootnetCrasher.School', 'parametres', 'typesanneescolaire');
        parent::__construct();
    }
    
    
}
