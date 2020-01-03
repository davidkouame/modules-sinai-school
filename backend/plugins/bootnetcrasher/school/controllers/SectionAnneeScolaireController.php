<?php namespace BootnetCrasher\School\Controllers;

use Backend\Classes\Controller;
use BackendMenu;
use BootnetCrasher\School\Models\MoyenneModel;
use BootnetCrasher\School\Models\SectionAnneeScolaireModel;
use Illuminate\Support\Facades\Redirect;
use Backend;
use October\Rain\Support\Facades\Flash;
use Bootnetcrasher\School\Jobs\ValidationSectionJob;
use Queue;

class SectionAnneeScolaireController extends Controller
{
    public $implement = [        'Backend\Behaviors\ListController',        'Backend\Behaviors\FormController'    ];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';

    public function __construct()
    {
        BackendMenu::setContext('BootnetCrasher.School', 'parametres', 'sectionsanneescolaire');
        parent::__construct();
    }

    public function listExtendQuery($query,$id)
    {
        $query->orderBy('id', 'desc');
    }

    // validation d'une section
    public function onValidate() {
        $sections = [];
        foreach (post("checked") as $id) {
            $section = SectionAnneeScolaireModel::find($id);
            $section->validated_at = now();
            $section->save();
            $sections["section_id"] = $section->id;
            // $this->SendSms($section);
        }
        if(count(post("checked")) > 1)
            Flash::success("Les sections ont été validé avec succès. Veillez patienter quelque minutes 
            pour que la modification soit completes.");
        else
            Flash::success("La section a été validé avec succès. Veillez patienter quelque minutes 
            pour que la modification soit completes");
        Queue::push(ValidationSectionJob::class, post("checked"));
        return Redirect::to(Backend::url('bootnetcrasher/school/sectionanneescolairecontroller'));
    }
}
