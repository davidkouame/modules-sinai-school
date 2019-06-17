<?php namespace Bootnetcrasher\School\Components;

use Cms\Classes\ComponentBase;
use ApplicationException;
use BootnetCrasher\School\Models\ExamenModel;

class DetailExamen extends ComponentBase
{

    public function componentDetails()
    {
        return [
            'name'        => 'Détail d\'examen',
            'description' => 'Implements a simple détail examen.'
        ];
    }

    public function defineProperties()
    {
        return [
        ];
    }

    public function onRun(){
        try {
            $examen_id = $this->param('examen_id');
            $examen = ExamenModel::find($examen_id);
            $this->page["examen"] = $examen;
            $this->page["active"] = 'administration';
        } catch (\Exception $e) {
            trace_log("Une erreur s'est produite lors de la recuperation des informations d'examen, error:".$e->getMessage());
        }
    }
}
