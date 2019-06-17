<?php namespace Bootnetcrasher\School\Components;

use Cms\Classes\ComponentBase;
use ApplicationException;
use BootnetCrasher\School\Models\ClasseModel;

class EmploisDuTemps extends ComponentBase
{

    public function componentDetails()
    {
        return [
            'name'        => 'Emplois du temps',
            'description' => 'Implements a simple emplois du temps.'
        ];
    }

    public function defineProperties()
    {
        return [
        ];
    }

    public function onRun(){
        
        // recuperation de toutes les emplois du temps
        $classes = ClasseModel::all();

        $this->page["classes"] = $classes;
    }
}
