<?php namespace BootnetCrasher\School\Controllers;

use Backend\Classes\Controller;
use BackendMenu;
use Redirect;
use Flash;
use Queue;
use Bootnetcrasher\School\Jobs\CalculMoyenneMatiereJob;

class MoyenneMatiereController extends Controller
{
    public $implement = [        'Backend\Behaviors\ListController',        'Backend\Behaviors\FormController'    ];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('BootnetCrasher.School', 'moyennes', 'moyennesmatieres');
    }
    
    public function listExtendQuery($query,$id)
    {
        $query->where('type_moyenne_id', 2);
    }

    public function onReloadCalculMoyenneMatiere(){
        Queue::push(CalculMoyenneMatiereJob::class, '');
        Flash::success("Le reload de calcul de moyenne a été effectué avec success !");
        return Redirect::refresh();
    }
}
