<?php namespace BootnetCrasher\School;

use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function registerComponents()
    {
        return [
            '\Bootnetcrasher\School\Components\Actualites' => 'actualites',
            '\Bootnetcrasher\School\Components\ActualitesAll' => 'actualitesall',
            '\Bootnetcrasher\School\Components\DetailActualite' => 'detailactualite',
            '\Bootnetcrasher\School\Components\ExamensAll' => 'examensall',
            '\Bootnetcrasher\School\Components\DetailExamen' => 'detailexamen',
            '\Bootnetcrasher\School\Components\ClubsActivitesAll' => 'clubsActivites',
            '\Bootnetcrasher\School\Components\DetailClubsActivites' => 'detailClubsActivites',
            '\Bootnetcrasher\School\Components\ProfesseursAll' => 'professeursAll',
            '\Bootnetcrasher\School\Components\DetailProfesseur' => 'detailProfesseur',
            '\Bootnetcrasher\School\Components\EmploisDuTemps' => 'emploisDuTemps',
            '\Bootnetcrasher\School\Components\Parametrages' => 'parametrages',
            '\Bootnetcrasher\School\Components\SujetsAll' => 'sujetsall',
            '\Bootnetcrasher\School\Components\Contact' => 'contact',
            '\Bootnetcrasher\School\Components\DetailSujet' => 'detailsujet',
            '\Bootnetcrasher\School\Components\Organigrame' => 'Organigrame',
            '\Bootnetcrasher\School\Components\FilAriane' => 'filAriane',
            '\Bootnetcrasher\School\Components\Galeries' => 'galeriesAll',
            '\Bootnetcrasher\School\Components\DetailGalerie' => 'detailGalerie',
            '\Bootnetcrasher\School\Components\ActivitesFinTrimestre' => 'activitesFinTrimestre'
        ];
    }

    public function registerSettings()
    {
    }
}
