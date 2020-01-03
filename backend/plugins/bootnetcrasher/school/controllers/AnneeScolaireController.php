<?php namespace BootnetCrasher\School\Controllers;

use Backend\Classes\Controller;
use BackendMenu;
use Bootnetcrasher\School\Jobs\ValidationAnneeScolaireJob;
use Bootnetcrasher\School\Jobs\ValidationSectionJob;
use BootnetCrasher\School\Models\SectionAnneeScolaireModel;
use Illuminate\Support\Facades\Redirect;
use October\Rain\Support\Facades\Flash;
use BootnetCrasher\School\Models\AnneeScolaireModel;
use Queue;
use Backend\Facades\Backend;

class AnneeScolaireController extends Controller
{
    public $implement = [        'Backend\Behaviors\ListController',        'Backend\Behaviors\FormController'    ];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';


    public function listExtendQuery($query,$id)
    {
        $query->orderBy('id', 'desc');
    }

    // validation d'une section
    public function onValidate() {
        $annees = [];
        foreach (post("checked") as $id) {
            $annee = AnneeScolaireModel::find($id);
            $annee->validated_at = now();
            $annee->save();
            $annees["annee_scolaire_id"] = $annee->id;
            // $this->SendSms($section);
        }
        if(count(post("checked")) > 1)
            Flash::success("Les années ont été validé avec succès. Veillez patienter quelque minutes 
            pour que la modification soit completes.");
        else
            Flash::success("L'annee scolaire a été validé avec succès. Veillez patienter quelque minutes 
            pour que la modification soit completes");
        Queue::push(ValidationAnneeScolaireJob::class, $annees);
        return Redirect::to(Backend::url('bootnetcrasher/school/anneescolairecontroller'));
    }

    public function __construct()
    {
        BackendMenu::setContext('BootnetCrasher.School', 'parametres', 'anneescolaire');
        parent::__construct();
    }
}
