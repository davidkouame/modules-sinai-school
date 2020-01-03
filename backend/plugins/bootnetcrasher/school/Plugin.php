<?php namespace BootnetCrasher\School;

use System\Classes\PluginBase;
use BootnetCrasher\School\Models\MoyenneModel;
use Bootnetcrasher\School\Classes\CalculMoyenne;
use Bootnetcrasher\School\Classes\Rang;
use Bootnetcrasher\School\Classes\CleanerDatabaseTest;
use Bootnetcrasher\School\Jobs\MoyenneJob;

use Queue;

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

    public function registerSchedule($schedule)
    {        
        // calcule de moyenne d'une matiere
        $schedule->call(function () {
            // $moyennes = MoyenneModel::all();
            // trace_log("Suppression des fichiers compresses au cours de la journée !!!");
            // trace_log($moyennes);
            Queue::push(MoyenneJob::class, '');
        })->daily();

        // 
        $schedule->call(function () {
            Queue::push(CalculMoyenneJob::class, '');
        })->daily();

        $schedule->call(function () {
            Queue::push("\BootnetCrasher\School\Jobs\MoyenneJob");
        })->everyWeek();

        // trace_log("bfhsdbfhdsfd");
        // Queue::push(CalculMoyenne::class, '');
        // Queue::push(Rang::class, '');
        // Queue::push(CleanerDatabaseTest::class, '');
        // $schedule->job(new MoyenneJob)->everyMinute();

        exec("ps ax | grep -i 'queue:work --daemon --sleep=5 --tries=3 > storage/logs/system.log' | grep -v 'grep'
        ", $pids);
        if(empty($pids)) {
            $schedule->command("queue:work --daemon --sleep=5 --tries=3 > storage/logs/system.log")->everyMinute();
        }
    }
    
    public function register()
    {
        $this->registerConsoleCommand('school:sendRapportMoyenne', '\BootnetCrasher\School\Console\SendRapportMoyenneCommand');
        $this->registerConsoleCommand('digit:calculMoyennes', '\BootnetCrasher\School\Console\CalculMoyenne');
        // $this->registerConsoleCommand('school.seeder', 'Bootnetcrasher\School\Console\Seeder');
    }
}
