<?php namespace BootnetCrasher\Parametrage\Controllers;

use Backend\Classes\Controller;
use BackendMenu;

class RaisonAbsenceController extends Controller
{
    public $implement = [        'Backend\Behaviors\ListController',        'Backend\Behaviors\FormController'    ];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';

    public function __construct()
    {
        BackendMenu::setContext('BootnetCrasher.Parametrage', 'parametrage', 'raisonabsence');
        parent::__construct();
    }
}
