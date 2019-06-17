<?php namespace Bootnetcrasher\School\Components;

use Cms\Classes\ComponentBase;
use ApplicationException;
use BootnetCrasher\School\Models\Professeurmodel;

class ProfesseursAll extends ComponentBase
{

    public function componentDetails()
    {
        return [
            'name'        => 'Professeurs all',
            'description' => 'Implements a simple all professeurs.'
        ];
    }

    public function defineProperties()
    {
        return [
        ];
    }

    public function onRun(){
        
        // recuperation de touts les professeurs
        $professeurs = Professeurmodel::paginate(5);

        $this->page["professeurs"] = $professeurs;
    }
}
