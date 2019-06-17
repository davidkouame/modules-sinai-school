<?php namespace Bootnetcrasher\School\Components;

use Cms\Classes\ComponentBase;
use ApplicationException;
use BootnetCrasher\School\Models\ClubModel;

class ClubsActivitesAll extends ComponentBase
{

    public function componentDetails()
    {
        return [
            'name'        => 'Clubs Activites',
            'description' => 'Implements a simple clubs activites.'
        ];
    }

    public function defineProperties()
    {
        return [
        ];
    }

    public function onRun(){
        
        // recuperation de touts les clubs activites
        $clubsActivites = ClubModel::paginate(5);
        $this->page["active"] = "viescolaire";
        $this->page["clubsActivites"] = $clubsActivites;
    }
}
