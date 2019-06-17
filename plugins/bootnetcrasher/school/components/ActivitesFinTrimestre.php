<?php namespace Bootnetcrasher\School\Components;

use Cms\Classes\ComponentBase;
use ApplicationException;
use BootnetCrasher\School\Models\ParametrageModel;

class ActivitesFinTrimestre extends ComponentBase
{

    public function componentDetails()
    {
        return [
            'name'        => 'ActiviteFinTrimestre',
            'description' => 'ActiviteFinTrimestre'
        ];
    }

    public function defineProperties()
    {
        return [
        ];
    }

    public function onRun(){
        try {
            // recuperation des parametres
            // dd(ParametrageModel::where('key', 'activite_fin_trimestre')->first()->logo->getPath());
            $activite_fin_trimestre = ParametrageModel::where('key', 'activite_fin_trimestre')->first();
            $parametrages = [
                                "activite_fin_trimestre" => $activite_fin_trimestre->logo->getPath()
                            ];
            $this->page["parametragesActivitesFinTrimestre"] = $parametrages;
            $this->page["active"] = 'espaceeleve';
        } catch (Exception $ex) {
            trace_log("Une erreur s'est produite lors de la recuperation des parametres, "
                    . "Raison :".$ex->getMessage());
        }
    }
}
