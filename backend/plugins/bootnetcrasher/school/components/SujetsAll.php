<?php namespace Bootnetcrasher\School\Components;

use Cms\Classes\ComponentBase;
use ApplicationException;
use BootnetCrasher\School\Models\SujetModel;

class SujetsAll extends ComponentBase
{

    public function componentDetails()
    {
        return [
            'name'        => 'Sujets all',
            'description' => 'Implements a simple all sujets.'
        ];
    }

    public function defineProperties()
    {
        return [
        ];
    }

    public function onRun(){
        // recuperation de touts les sujets
        $sujets = SujetModel::paginate(5);

        $this->page["sujets"] = $sujets;
    }
}
