<?php namespace Bootnetcrasher\School\Components;

use Cms\Classes\ComponentBase;
use ApplicationException;
use BootnetCrasher\School\Models\ClubModel;

class DetailClubsActivites extends ComponentBase
{

    public function componentDetails()
    {
        return [
            'name'        => 'Détail de club d\'actviité',
            'description' => 'Implements a simple détail activité.'
        ];
    }

    public function defineProperties()
    {
        return [
        ];
    }

    public function onRun(){
        try {
            $club_activite_id = $this->param('club_activite_id');
            $clubActivite = ClubModel::find($club_activite_id);
            $this->page["clubActivite"] = $clubActivite;
        } catch (\Exception $e) {
            trace_log("Une erreur s'est produite lors de la recuperation des informations d'un club d'activité, error:".$e->getMessage());
        }
    }
}
