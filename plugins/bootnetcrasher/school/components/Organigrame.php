<?php namespace Bootnetcrasher\School\Components;

use Cms\Classes\ComponentBase;
use ApplicationException;
use BootnetCrasher\School\Models\OrganigrameModel;

class Organigrame extends ComponentBase
{

    public function componentDetails()
    {
        return [
            'name'        => 'Ogarnigrame',
            'description' => 'Implements a simple organigrame.'
        ];
    }

    public function defineProperties()
    {
        return [
        ];
    }

    public function onRun(){
        $this->page["organigrame"] = OrganigrameModel::all();
        $this->page["premierParent"] = OrganigrameModel::
                whereNull('parent_organigrame_id')->first();
        $this->page["active"] = 'administration';
        // dd($this->page["premierParent"]->getChildren());
    }
}