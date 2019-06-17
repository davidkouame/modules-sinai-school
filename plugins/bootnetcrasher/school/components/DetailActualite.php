<?php namespace Bootnetcrasher\School\Components;

use Cms\Classes\ComponentBase;
use ApplicationException;
use BootnetCrasher\School\Models\ActualiteModel;

class DetailActualite extends ComponentBase
{

    public function componentDetails()
    {
        return [
            'name'        => 'Détail d\'actualite',
            'description' => 'Implements a simple détail actualite.'
        ];
    }

    public function defineProperties()
    {
        return [
        ];
    }

    public function onRun(){
        try {
            $actualite_id = $this->param('actualite_id');
            $actualite = ActualiteModel::find($actualite_id);
            $this->page["actualite"] = $actualite;
            $this->page["active"] = 'actualites';
        } catch (\Exception $e) {
            trace_log("Une erreur s'est produite lors de la recuperation des informations d'une actualite, erro:".$e->getMessage());
        }
    }
}
