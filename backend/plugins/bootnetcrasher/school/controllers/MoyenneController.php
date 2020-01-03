<?php namespace BootnetCrasher\School\Controllers;

use Backend\Classes\Controller;
use BackendMenu;
use BootnetCrasher\School\Models\MoyenneModel;
use Backend;
use Illuminate\Support\Facades\Redirect;

class MoyenneController extends Controller
{
    public $implement = [        'Backend\Behaviors\ListController',        'Backend\Behaviors\FormController'    ];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';

    public function __construct()
    {
        parent::__construct();
    }
    
    // validation d'une moyenne
    public function onValidate(){
        foreach(post("checked") as $id){
            $moyenne = MoyenneModel::find($id);
            $moyenne->validated_at = now();
            $moyenne->save();
            return Redirect::to(Backend::url('bootnetcrasher/school/moyennecontroller'));
        }
    }

    public function listExtendQuery($query,$id)
    {
        $query->orderBy('id', 'desc');
    }
}
