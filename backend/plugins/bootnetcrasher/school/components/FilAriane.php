<?php namespace Bootnetcrasher\School\Components;

use Cms\Classes\ComponentBase;

class FilAriane extends ComponentBase
{

    public function componentDetails()
    {
        return [
            'name'        => 'Fil d\'ariane',
            'description' => 'Implements a simple fil ariane.'
        ];
    }

    public function defineProperties()
    {
        return [
        ];
    }

    public function onRun(){
        
        // recuperation de toutes les actualites
        // $actualites = ActualiteModel::paginate(4);/

        // $this->page["actualites"] = $actualites;
    }
}
