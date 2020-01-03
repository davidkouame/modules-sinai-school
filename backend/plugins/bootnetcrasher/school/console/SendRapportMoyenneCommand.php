<?php namespace BootnetCrasher\School\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

use Mail;
use Digit\OffreFormation\Models\OffreEmploiModel;
use Digit\Demandeur\Models\DemandeurEmploiModel;
use Digit\Demandeur\Controllers\DemandeursDuConseillerController;
use DB;
use Queue;

class SendRapportMoyenneCommand extends Command
{
    /**
     * @var string The console command name.
     */
    protected $name = 'school:sendRapportMoyenne';

    /**
     * @var string The console command description.
     */
    protected $description = 'Cette commande permet d\'envoyer des rapports '
            . 'de moyennes aux parents d\'élèves ';

    /**
     * Execute the console command.
     * @return void
     */
    public function handle()
    {   
        Queue::push("\BootnetCrasher\School\Jobs\MoyenneJob");
    }

    /**
     * Get the console command arguments.
     * @return array
     */
    protected function getArguments()
    {
        return [];
    }

    /**
     * Get the console command options.
     * @return array
     */
    protected function getOptions()
    {
        return [];
    }

}