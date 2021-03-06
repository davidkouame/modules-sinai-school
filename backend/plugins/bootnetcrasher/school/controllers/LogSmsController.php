<?php namespace BootnetCrasher\School\Controllers;

use Backend\Classes\Controller;
use BackendMenu;

class LogSmsController extends Controller
{
    public $implement = [        'Backend\Behaviors\ListController',        'Backend\Behaviors\FormController'    ];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('BootnetCrasher.School', 'parametres', 'logsms');
    }

    public function listExtendQuery($query,$id)
    {
        $query->orderBy('id', 'desc');
    }
}
