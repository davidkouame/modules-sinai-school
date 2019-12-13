<?php namespace BootnetCrasher\School\Controllers;

use Backend\Classes\Controller;
use BackendMenu;

class AnneeScolaireController extends Controller
{
    public $implement = [        'Backend\Behaviors\ListController',        'Backend\Behaviors\FormController'    ];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';
}
