<?php namespace BootnetCrasher\School\Controllers;

use Backend\Classes\Controller;
use BackendMenu;

class ClasseController extends Controller
{
    public $implement = [        'Backend\Behaviors\ListController',        'Backend\Behaviors\FormController',        'Backend\Behaviors\ReorderController'    ];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';
    public $reorderConfig = 'config_reorder.yaml';
    // public $relationConfig = 'config_relation.yaml';

    public function __construct()
    {
        parent::__construct();
    }

    public function update($classeId = null){
        $config = $this->makeConfig('$/bootnetcrasher/school/models/classemodel/fields.yaml');
        $model = \BootnetCrasher\School\Models\ClasseModel::find($classeId);
        $config->model = $model;
        $widget = $this->makeWidget('Backend\widgets\Form', $config);
        $this->vars['model'] = $config->model;
        $widget->bindToController();
        $this->vars['widget'] = $widget;
    }
}
