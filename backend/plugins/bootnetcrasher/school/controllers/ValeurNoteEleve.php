<?php namespace BootnetCrasher\School\Controllers;

use Backend\Classes\Controller;
use BackendMenu;
use BootnetCrasher\School\Models\NoteEleve;
use Redirect;
use Backend;

class ValeurNoteEleve extends Controller
{
    public $implement = [
        'Backend\Behaviors\ListController', 
        'Backend\Behaviors\FormController',
        'Backend\Behaviors\RelationController'];
    
    public $listConfig = [
        'default' => 'config_list.yaml',
        'config_list_valeur_note' => 'config_list_valeur_note.yaml'
        ];
    public $formConfig = 'config_form.yaml';
    public $relationConfig = 'config_relation.yaml';

    public function __construct()
    {
        BackendMenu::setContext('BootnetCrasher.School', 'notes', 'valeursnoteseleves');
        parent::__construct();
    }
    
    public function listExtendQuery($query, $id)
    {
        if($this->params && $this->params[0]){
            $query->where('note_id', $this->params[0])
                ->whereNull('deleted_at')->orderBy('id', 'desc');
        }else{
            $query->orderBy('id', 'desc');
        }
        
    }
    
    public function onSaveCustom($id =null){
        $data = post();
        foreach($data["NoteEleve"]["eleve"] as $eleveId){
            $elevenote = new \BootnetCrasher\School\Models\NoteEleve;
            $elevenote->eleve_id = $eleveId;
            $elevenote->note_id = $data["NoteEleve"]["note"];
            $elevenote->valeur = $data["NoteEleve"]["valeur"];
            $elevenote->save();
        }
        \Flash::success("Les valeurs des notes ont été enregistrées avec succès !");
    }

    public function update($noteId = null){

        $config = $this->makeConfig('$/bootnetcrasher/school/models/notemodel/valeurnotefields.yaml');
        $model = \BootnetCrasher\School\Models\NoteModel::find($noteId);
        $config->model = $model;
        $widget = $this->makeWidget('Backend\widgets\Form', $config);
        $this->vars['model'] = $config->model;
        $widget->bindToController();
        $this->vars['widget'] = $widget;

        // \Session::put('noteId', $noteId);
        // $model = \BootnetCrasher\School\Models\NoteModel::where('id', 3)->get();
        // $model = NoteEleve::all();
        // $config = $this->makeConfig('$/bootnetcrasher/school/models/noteeleve/columns.yaml');
        // $config->model = $model;
        // $widget = $this->makeWidget('Backend\widgets\Form', $config);
        // $this->vars['model'] = $config->model;
        $this->vars['liste'] = 'config_list_valeur_note';
        // $this->vars['model'] = NoteEleve::where('id', 18)->get();
        // dd($this->vars['model']);
        // dd($this->asExtension('ListController'));
        $this->asExtension('ListController')->index();
    }

    public function onDeleteCusom($noteEleveId = null){
        var_dump($noteEleveId);
    }
    
    public function onAddValueStudent(){
        $noteId = post('noteId');
        $valeur = post('valeur');
        $notesElevesId = post('students');
        foreach($notesElevesId as $noteEleveId){
            $noteeleve = NoteEleve::find($noteEleveId);
            $noteeleve->valeur = $valeur;
            $noteeleve->save();
        }
        \Flash::success("Valeur ajoutée avec succès !");
        return Redirect::to(Backend::url('bootnetcrasher/school/valeurnoteeleve/update/'.$noteId));
    }

    /*// permet d'ajouter un ou plusieurs élèves à une note
    public function addStudentNote($noteId = null){
        dd($noteId);
    }*/

}
