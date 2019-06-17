<?php namespace Bootnetcrasher\School\Components;

use Cms\Classes\ComponentBase;
use ApplicationException;
use BootnetCrasher\School\Models\Professeurmodel;

class DetailProfesseur extends ComponentBase
{

    public function componentDetails()
    {
        return [
            'name'        => 'Détail de professeur',
            'description' => 'Implements a simple détail professeur.'
        ];
    }

    public function defineProperties()
    {
        return [
        ];
    }

    public function onRun(){
        try {
            $professeur_id = $this->param('professeur_id');
            $professeur = Professeurmodel::find($professeur_id);
            $this->page["professeur"] = $professeur;
        } catch (\Exception $e) {
            trace_log("Une erreur s'est produite lors de la recuperation des informations d'un professeur, error:".$e->getMessage());
        }
    }
}
