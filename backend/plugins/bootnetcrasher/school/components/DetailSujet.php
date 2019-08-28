<?php namespace Bootnetcrasher\School\Components;

use Cms\Classes\ComponentBase;
use ApplicationException;
use BootnetCrasher\School\Models\SujetModel;

class DetailSujet extends ComponentBase
{

    public function componentDetails()
    {
        return [
            'name'        => 'Détail du sujet',
            'description' => 'Implements a simple détail sujet.'
        ];
    }

    public function defineProperties()
    {
        return [
        ];
    }

    public function onRun(){
        try {
            $sujet_id = $this->param('sujet_id');
            $sujet = SujetModel::find($sujet_id);
            $this->page["sujet"] = $sujet;
        } catch (\Exception $e) {
            trace_log("Une erreur s'est produite lors de la recuperation des informations du sujet, error:".$e->getMessage());
        }
    }
}
