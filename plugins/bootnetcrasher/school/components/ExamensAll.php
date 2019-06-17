<?php namespace Bootnetcrasher\School\Components;

use Cms\Classes\ComponentBase;
use ApplicationException;
use BootnetCrasher\School\Models\ExamenModel;

class ExamensAll extends ComponentBase
{

    public function componentDetails()
    {
        return [
            'name'        => 'Examens all',
            'description' => 'Implements a simple all examens.'
        ];
    }

    public function defineProperties()
    {
        return [
        ];
    }

    public function onRun(){
        // recuperation de touts les examens
        $examensall = ExamenModel::whereNotNull('published_at')->paginate(5);
        $this->page["examensall"] = $examensall;
        $this->page["active"] = 'administration';
    }
}
