<?php namespace BootnetCrasher\Parametrage\Controllers;

use Backend\Classes\Controller;
use BackendMenu;
use Flash;
use Queue;

class ParametrageSmsController extends Controller
{
    public $implement = [        'Backend\Behaviors\FormController'    ];
    
    public $formConfig = 'config_form.yaml';

    public function __construct()
    {
        parent::__construct();
    }

    public function onSendRapport($id){
        Queue::push("\BootnetCrasher\School\Jobs\MoyenneJob");
        Flash::success("Votre rapport a été envoyé avec success.");
    }
}
