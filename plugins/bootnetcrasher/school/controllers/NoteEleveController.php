<?php namespace BootnetCrasher\School\Controllers;

use Backend\Classes\Controller;
use BackendMenu;
use Redirect;
use Backend;

class NoteEleveController extends Controller
{
    public $implement = [        'Backend\Behaviors\ListController',        'Backend\Behaviors\FormController'    ];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';

    public function __construct()
    {
        $noteId = \Session::get('noteId');
        $this->vars['noteId'] = $noteId;
        parent::__construct();
    }

    public function onSaveCustom(){
        $noteId = \Session::get('noteId');
        $eleveId = post("NoteEleve")["eleve"];
        $eleveNote = \BootnetCrasher\School\Models\NoteEleve::where('eleve_id', $eleveId)->where('note_id', $noteId)->first();
        if(!$eleveNote){
            $noteEleve = new \BootnetCrasher\School\Models\NoteEleve();
            $noteEleve->eleve_id = $eleveId;
            $noteEleve->note_id = $noteId;
            $noteEleve->save();
        }
        return Redirect::to(Backend::url('bootnetcrasher/school/valeurnoteeleve/update/' . $noteId));
    }
}
