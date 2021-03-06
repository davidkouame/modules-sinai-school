<?php namespace BootnetCrasher\School\Controllers;

use Backend\Classes\Controller;
use BackendMenu;

class TypeNoteController extends Controller
{
    public $implement = [        'Backend\Behaviors\ListController',        'Backend\Behaviors\FormController'    ];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';

    public function __construct()
    {
        BackendMenu::setContext('BootnetCrasher.School', 'parametres');
        parent::__construct();
    }

    public function listExtendQuery($query,$id)
    {
        $query->orderBy('id', 'desc');
    }
}
