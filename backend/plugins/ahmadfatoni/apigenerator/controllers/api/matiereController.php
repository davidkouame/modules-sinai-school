<?php namespace AhmadFatoni\ApiGenerator\Controllers\API;

use BootnetCrasher\School\Models\ClasseMatiereModel;
use Cms\Classes\Controller;
use BackendMenu;

use Illuminate\Http\Request;
use AhmadFatoni\ApiGenerator\Helpers\Helpers;
use Illuminate\Support\Facades\Validator;
use BootnetCrasher\School\Models\MatiereModel;
use BootnetCrasher\School\Models\ClasseEleveModel;
use DB;

class matiereController extends Controller
{
	protected $MatiereModel;

    protected $helpers;

    private $rules = [
        "libelle" => "required",
        "typematiere_id" => 'required'
    ];
    
    private $messages = [
        "libelle.required" => "Veuillez entre un libellé",
        "typematiere_id.required" => "Veuillez entrer un type de matière"
    ];

    public function __construct(MatiereModel $MatiereModel, Helpers $helpers)
    {
        parent::__construct();
        $this->MatiereModel    = $MatiereModel;
        $this->helpers          = $helpers;
    }

    public function index(Request $request){

        $data = $this->MatiereModel->with(array(
            'classematiere' => function($query){
                $query->select('*');
            },
            'typematiere'=> function($query){
                $query->select('*');
            }
        ));

        foreach($request->except('page') as $key => $value){
            if($key == "eleve_id"){
                $classeeleve = ClasseEleveModel::where('eleve_id', $value)->first();
                $classe_id = $classeeleve ? $classeeleve->classe_id : null;
                $data = $data->whereHas(
                    'classematiere', function($query) use($classe_id){
                        $query->where('classe_id', $classe_id)->whereHas(
                            'classe',function($queryClasse){
                                $queryClasse->select('*');
                            }
                        );
                    }
                );
            }elseif($key == 'parent_id'){
                $data = $data->whereHas(
                    'classematiere',function($query) use($request){
                        $query->whereHas(
                            'classe',function($queryClasse) use($request){
                                $queryClasse->whereHas('eleves',function($queryEleves) use($request){
                                        $queryEleves->whereHas(
                                            'eleve',function($queryEleve) use($request){
                                                $queryEleve->where('parent_id', $request->get('parent_id'))
                                                ->select('*');
                                            }
                                        );
                                    }
                                );
                            }
                        );
                    }
                );
            }elseif($key == "libelle"){
                $data = $data->where($key, 'like', '%'.$value.'%');
            }elseif($key == "search"){
                $data = $data->where("libelle", 'like', '%'.$value.'%');
            }elseif($key == "annee_scolaire_id"){
                $classeeleve = ClasseEleveModel::where('eleve_id', $value)->first();
                $classe_id = $classeeleve ? $classeeleve->classe_id : null;
                $data = $data->whereHas(
                    'classematiere', function($query) use($request){
                        $query->where('annee_scolaire_id', $request->get('annee_scolaire_id'))
                                ->select('*');
                    }
                );
                // $data = $data->where($key, 'like', '%'.$value.'%');
            }else{
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

    public function indexV2(Request $request){
        $data = DB::table('bootnetcrasher_school_matiere')
            ->join('bootnetcrasher_school_classe_matiere', 'bootnetcrasher_school_matiere.id', '=', 'bootnetcrasher_school_classe_matiere.matiere_id')
            ->join('bootnetcrasher_school_classe_eleve', 'bootnetcrasher_school_classe_eleve.classe_id', '=', 'bootnetcrasher_school_classe_matiere.classe_id')
            ->join('bootnetcrasher_school_eleve', 'bootnetcrasher_school_eleve.id', '=', 'bootnetcrasher_school_classe_eleve.eleve_id')
            ->join('bootnetcrasher_school_classe', 'bootnetcrasher_school_classe.id', '=', 'bootnetcrasher_school_classe_eleve.classe_id');
        foreach($request->except('page') as $key => $value){
            if($key == "eleve_id"){
                $data->where('bootnetcrasher_school_classe_eleve.eleve_id', '=', $request->get('eleve_id'));
            }elseif ($key == "parent_id"){
                $data->where('bootnetcrasher_school_eleve.parent_id', '=', $request->get('parent_id'));
            }elseif ($key == "libelle"){
                $data = $data->where("bootnetcrasher_school_matiere.libelle", 'like', '%'.$value.'%');
            }elseif($key == "annee_scolaire_id"){
                $data->where('bootnetcrasher_school_classe_eleve.annee_scolaire_id', '=', $request->get('annee_scolaire_id'));
            }else{
                $data = $data->where($key, $value);
            }
        }
        $data = $data->select('bootnetcrasher_school_matiere.libelle', 'bootnetcrasher_school_classe_matiere.coefficient',
            'bootnetcrasher_school_matiere.id')->get()->toArray();
        return $this->helpers->apiArrayResponseBuilder(200, 'success', $data);
    }
    
    public function all(Request $request){

        $data = $this->MatiereModel->with(array(
            'classematiere' => function($query){
                $query->select('*');
            }
        ));

        foreach($request->except('page') as $key => $value){
            if($key == "eleve_id"){
                $classeeleve = ClasseEleveModel::where('eleve_id', $value)->first();
                $classe_id = $classeeleve ? $classeeleve->classe_id : null;
                $data = $data->whereHas(
                    'classematiere', function($query) use($classe_id){
                        $query->where('classe_id', $classe_id)->whereHas(
                            'classe',function($queryClasse){
                                $queryClasse->select('*');
                            }
                        );
                    }
                );
            }elseif($key == 'parent_id'){
                $data = $data->whereHas(
                    'classematiere',function($query) use($request){
                        $query->whereHas(
                            'classe',function($queryClasse) use($request){
                                $queryClasse->whereHas(
                                'eleves',function($queryEleves) use($request){
                                        $queryEleves->whereHas(
                                            'eleve',function($queryEleve) use($request){
                                                $queryEleve->where('parent_id', $request->get('parent_id'))
                                                ->select('*');
                                            }
                                        );
                                    }
                                );
                            }
                        );
                    }
                );
            }elseif($key == "libelle"){
                $data = $data->where($key, 'like', '%'.$value.'%');
            }else{
                $data = $data->where($key, $value);
            }
        }

        $data = $data->get()->toArray();

        return $this->helpers->apiArrayResponseBuilder(200, 'success', $data);
    }

    public function show($id){
        $data = $this->MatiereModel->with(array(
            'typematiere' => function($query){
                $query->select('*');
            },'classematiere' => function($query){
                $query->select('*');
            }
        ))->where('id',$id)->first();

        if($data){

            return $this->helpers->apiArrayResponseBuilder(200, 'success', $data);

        }

        $this->helpers->apiArrayResponseBuilder(400, 'bad request', ['error' => 'invalid key']);

    }

    public function store(Request $request){
    	$arr = $request->all();
        $validation = Validator::make($request->all(), $this->rules, $this->messages);
        if($validation->passes() ){
            while ( $data = current($arr)) {
                $this->MatiereModel->{key($arr)} = $data;
                next($arr);
            }
            $this->MatiereModel->save();
            return $this->helpers->apiArrayResponseBuilder(201, 'created', ['id' => $this->MatiereModel->id]);
        }else{
            return $this->helpers->apiArrayResponseBuilder(400, 'fail', $validation->errors() );
        }
    }

    public function update($id, Request $request){
        $validation = Validator::make($request->all(), $this->rules, $this->messages);
        if($validation->passes()){
            $status = $this->MatiereModel->where('id',$id)->update($request->all());
            if( $status ){
                return $this->helpers->apiArrayResponseBuilder(200, 'success', 'Data has been updated successfully.');
            }else{
                return $this->helpers->apiArrayResponseBuilder(400, 'bad request', 'Error, data failed to update.');
            }
        }else{
            return $this->helpers->apiArrayResponseBuilder(400, 'fail', $validation->errors() );
        }
    }

    public function delete($id){

        $this->MatiereModel->where('id',$id)->delete();

        return $this->helpers->apiArrayResponseBuilder(200, 'success', 'Data has been deleted successfully.');
    }

    public function destroy($id){

        $this->MatiereModel->where('id',$id)->delete();

        return $this->helpers->apiArrayResponseBuilder(200, 'success', 'Data has been deleted successfully.');
    }

    /*
     * Search matiere by professeur_id, classe_id
     * params classe_id int
     * params professeur_id int
     * return Array
     */
    public function searchMatiereByClasseAndProfesseur(Request $request){
        $data = ClasseMatiereModel::where('classe_id', $request->get('classe_id'))
            ->where('professeur_id', $request->get('professeur_id'))
            ->first();
        if($data)
            $data = $data->matiere;
        return $this->helpers->apiArrayResponseBuilder(200, 'success', $data);
    }


    public static function getAfterFilters() {return [];}
    public static function getBeforeFilters() {return [];}
    public static function getMiddleware() {return [];}
    public function callAction($method, $parameters=false) {
        return call_user_func_array(array($this, $method), $parameters);
    }
    
}