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
        parent::__construct();
        // $noteId = \Session::get('noteId');
        if(get('noteId')){
            $this->vars['noteId'] = get('noteId');
        }else{
            // to do error when noteId exist
        }
    }
    
    

    public function onSaveCustom(){
        $noteId = get('noteId');
        if($noteId){
            // $noteId = \Session::get('noteId');
            $noteId = $noteId;
            $eleveId = post("NoteEleve")["eleve"];

            $eleveNote = \BootnetCrasher\School\Models\NoteEleve::where('eleve_id', $eleveId)->where('note_id', $noteId)->first();
            if(!$eleveNote){
                $noteEleve = new \BootnetCrasher\School\Models\NoteEleve();
                $noteEleve->eleve_id = $eleveId;
                $noteEleve->note_id = $noteId;
                $noteEleve->save();
            }
            
            return Redirect::to(Backend::url('bootnetcrasher/school/valeurnoteeleve/update/' . $noteId));
        }else{
            // to do error when noteId exist
        }
        // var_dump($noteId);
        // dd();
        
    }
}
