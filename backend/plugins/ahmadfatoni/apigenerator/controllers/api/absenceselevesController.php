<?php namespace AhmadFatoni\ApiGenerator\Controllers\API;

use Cms\Classes\Controller;
use BackendMenu;

use Illuminate\Http\Request;
use AhmadFatoni\ApiGenerator\Helpers\Helpers;
use BootnetCrasher\School\Models\AbsenceEleveModel;
use BootnetCrasher\School\Models\EleveModel;
use Illuminate\Support\Facades\Validator;

class absenceselevesController extends Controller
{
    protected $AbsenceEleveModel;

    protected $helpers;

    private $rules = [
        "heure_debut_cours" => "required",
        "heure_fin_cours" => 'required',
        "raisonabsence_id" => 'required',
        "eleve_id" => 'required',
    ];
    
    private $messages = [
        "heure_debut_cours.required" => "Veuillez entrez une date de début",
        "heure_fin_cours.required" => "Veuillez entrez une heure de fin",
        "raisonabsence_id.required" => "Veuillez sélectionnez une raison d'absence",
        "eleve_id.required" => "Veuillez sélectionnez un élève",
    ];

    public function __construct(AbsenceEleveModel $AbsenceEleveModel, Helpers $helpers)
    {
        parent::__construct();
        $this->AbsenceEleveModel = $AbsenceEleveModel;
        $this->helpers = $helpers;
    }


    public function index(Request $request)
    {
        $data = $this->AbsenceEleveModel->with(array(
                'raisonabsence' => function ($query) {
                    $query->select('*');
                },
                'eleve' => function ($query) {
                    $query->select('*');
                },)
        );
        if ($request->has('classe_id')) {
            $data = $data->whereHas('eleve', function ($query) use ($request) {
                $query->whereHas('classeseleves', function ($q) use ($request) {
                    if ($request->has('classe_id')) {
                        $q->where('classe_id', $request->get('classe_id'));
                    }
                });
            });
        }
        foreach ($request->except('page', 'classe_id') as $key => $value) {
            if ($key == "parent_id") {
                $data = $data->whereHas('eleve', function ($query) use ($request, $key) {
                    $query->where($key, $request->get('parent_id'));
                });
            } elseif ($key == "search") {
                $date = explode("/", trim($request->get('search')));
                if (count($date) == 3) {
                    $newdate = $date[2] . "-" . $date[1] . "-" . $date[0];
                    // dd($newdate);
                    $data = $data->whereDate("heure_debut_cours", "=", $newdate)
                        ->orWhereDate("heure_fin_cours", "=", $newdate);
                } else {
                        $data = $data->whereHas('raisonabsence', function($queryRaisonAbsence) use($request) {
                            $queryRaisonAbsence->where("libelle", 'like', '%'.$request->get('search').'%');
                        })->orWhereHas('eleve', function($queryEleve) use($request) {
                            $queryEleve->where("name", 'like', '%'.$request->get('search').'%')
                            ->orWhere("surname", 'like', '%'.$request->get('search').'%');
                        });
                }
                // $data = $data->whereHas('eleve', function ($query) use($request, $key) {
                //     $query->where($key,$request->get('parent_id'));
                // });
            } else {
                $data = $data->where($key, $value);
            }
        }
        if($request->has('page') && $request->get('page') == 0){
            $data = $data->orderBy('created_at', 'desc')->get()->toArray();
        }else{
            $data = $data->orderBy('created_at', 'desc')->paginate(10)->toArray();
        }
        return $this->helpers->apiArrayResponseBuilder(200, 'success', $data);
    }


    public function show($id)
    {
        $data = $this->AbsenceEleveModel->with(array(
            'raisonabsence' => function ($query) {
                $query->select('*');
            },
            'eleve' => function ($query) {
                $query->select('*');
            },))->select('*')->where('id', '=', $id)->first();
        return $this->helpers->apiArrayResponseBuilder(200, 'success', $data);
    }

    public function store(Request $request)
    {
        $arr = $request->all();
        while ($data = current($arr)) {
            $this->AbsenceEleveModel->{key($arr)} = $data;
            next($arr);
        }
        $validation = Validator::make($request->all(), $this->rules, $this->messages);
        if($validation->passes()){
            $this->AbsenceEleveModel->commentaire = $request->get("commentaire");
            $this->AbsenceEleveModel->eleve_id = $request->get("eleve_id");
            $this->AbsenceEleveModel->heure_debut_cours = $request->get("heure_debut_cours");
            $this->AbsenceEleveModel->heure_fin_cours = $request->get("heure_fin_cours");
            $this->AbsenceEleveModel->raisonabsence_id = $request->get("raisonabsence_id");
            $this->AbsenceEleveModel->section_annee_scolaire_id = $request->get("section_annee_scolaire_id");
            if (count($this->AbsenceEleveModel->rules) > 0) {
                $validation = Validator::make($request->all(), $this->AbsenceEleveModel->rules);
                if ($validation->passes()) {
                    $this->AbsenceEleveModel->save();
                    return $this->helpers->apiArrayResponseBuilder(201, 'created', ['id' => $this->AbsenceEleveModel->id]);
                } else {
                    return $this->helpers->apiArrayResponseBuilder(400, 'fail', $validation->errors());
                }
            } else {
                $absenceelevemodel = $this->AbsenceEleveModel->save();
                return $this->helpers->apiArrayResponseBuilder(201, 'created', $this->AbsenceEleveModel->toArray());
            }
        }else{
            return $this->helpers->apiArrayResponseBuilder(400, 'fail', $validation->errors() );
        }
    }

    public function update($id, Request $request){
        $validation = Validator::make($request->all(), $this->rules, $this->messages);
        if($validation->passes()){
            $status = $this->AbsenceEleveModel->where('id', $id)->update($request->all());
            if ($status) {
                return $this->helpers->apiArrayResponseBuilder(200, 'success',
                    $this->AbsenceEleveModel->where('id', $id)->first()->toArray());
            } else {
                return $this->helpers->apiArrayResponseBuilder(400, 'bad request', 'Error, data failed to update.');
            }
        }else{
            return $this->helpers->apiArrayResponseBuilder(400, 'fail', $validation->errors() );
        }
    }

    public function delete($id)
    {

        $this->AbsenceEleveModel->where('id', $id)->delete();

        return $this->helpers->apiArrayResponseBuilder(200, 'success', 'Data has been deleted successfully.');
    }

    public function destroy($id)
    {

        $this->AbsenceEleveModel->where('id', $id)->delete();

        return $this->helpers->apiArrayResponseBuilder(200, 'success', 'Data has been deleted successfully.');
    }


    public static function getAfterFilters()
    {
        return [];
    }

    public static function getBeforeFilters()
    {
        return [];
    }

    public static function getMiddleware()
    {
        return [];
    }

    public function callAction($method, $parameters = false)
    {
        return call_user_func_array(array($this, $method), $parameters);
    }

}
