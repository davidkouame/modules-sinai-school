<?php namespace AhmadFatoni\ApiGenerator\Controllers\API;

use Cms\Classes\Controller;
use BackendMenu;

use Illuminate\Http\Request;
use AhmadFatoni\ApiGenerator\Helpers\Helpers;
use BootnetCrasher\School\Models\ClasseMatiereModel;
use Illuminate\Support\Facades\Validator;
class classeProfesseurMatiereController extends Controller
{
    protected $ClasseMatiereModel;

    protected $helpers;

    private $rules = [
        "annee_scolaire_id" => "required",
        "classe_id" => "required",
        "coefficient" => "required",
        "matiere_id" => "required",
        "professeur_id" => "required",
    ];

    private $messages = [
        "annee_scolaire_id.required" => "Veuillez entrer une année scolaire",
        "classe_id.required" => "Veuillez sélectionner une classe",
        "coefficient.required" => "Veuillez entrer un coéfficient",
        "matiere_id.required" => "Veuillez sélectionner une matière",
        "professeur_id.required" => "Veuillez sélectionner un professeur",
    ];

    public function __construct(ClasseMatiereModel $ClasseMatiereModel, Helpers $helpers)
    {
        parent::__construct();
        $this->ClasseMatiereModel    = $ClasseMatiereModel;
        $this->helpers          = $helpers;
    }

    
    public function index(Request $request){
        $data = $this->ClasseMatiereModel->with(array(
            'matiere'=>function($query){
                $query->select('*');
            },
            'classe'=>function($query){
                $query->with(array(
                    'professeurprincipal' => function($query){
                        $query->select('*');
                    }
                ));
            },
            'professeur'=>function($query){
                $query->select('*');
            }, )); //->select('*')->get()->toArray();
        $searchProfesseur = null;
        $searchEleve = null;
        foreach($request->except(['page']) as $key => $value){
            if($key == "libelle"){
                $data = $data->where($key, 'like', '%'.$value.'%');
            }elseif ($key == "professeur_id") {
                $searchProfesseur = true;
                $data = $data->where($key, $value);
            }elseif ($key == "parent_id") {
                $searchProfesseur = true;
            }elseif ($key == "eleve_id") {
                $searchEleve = true;
                $data = $data->wherehas(
                    'classe',function($query) use($request){
                        $query->whereHas(
                            'eleves',function($query) use($request){
                                $query->where('eleve_id', $request
                                    ->get('eleve_id'))->select('*');
                            }
                        );
                    }
                );
            }else{
                $data = $data->where($key, $value);
            }
        }
        if($searchProfesseur){
            $data = $data->orderBy('created_at', 'desc')->get()->unique('classe_id')->toArray();
        }elseif($searchEleve){
            $data = $data->orderBy('created_at', 'desc')->get()->unique('matiere_id')->toArray();
        }else{
            $data = $data->orderBy('created_at', 'desc')->get()->toArray();
        }
        return $this->helpers->apiArrayResponseBuilder(200, 'success', $data);
    }

    
    public function show($id){ 
        $data = $this->ClasseMatiereModel->with(array(
            'matiere'=>function($query){
                $query->select('*');
            },
            'classe'=>function($query){
                $query->select('*');
            },
            'professeur'=>function($query){
                $query->select('*');
            }, ))->select('*')->where('id', '=', $id)->first();
        return $this->helpers->apiArrayResponseBuilder(200, 'success', $data);
    }

    public function store(Request $request){

        $arr = $request->all();
        // dd($request->all());

        while ( $data = current($arr)) {
            $this->ClasseMatiereModel->{key($arr)} = $data;
            next($arr);
        }

        $validation = Validator::make($request->all(), $this->rules, $this->messages);
        
        if($validation->passes() ){
            // dd($this->ClasseMatiereModel);
            $this->ClasseMatiereModel->classe_id = $request->get('classe_id');
            $this->ClasseMatiereModel->save();
            return $this->helpers->apiArrayResponseBuilder(201, 'created', ['id' => $this->ClasseMatiereModel->id]);
        }else{
            return $this->helpers->apiArrayResponseBuilder(400, 'fail', $validation->errors() );
        }

    }

    public function update($id, Request $request){
        $arr = $request->all();
        $arr["classe_id"] = $id;
        $validation = Validator::make($arr, $this->rules, $this->messages);
        if($validation->passes() ){
            $status = $this->ClasseMatiereModel->where('id',$id)->update($request->all());
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

        $this->ClasseMatiereModel->where('id',$id)->delete();

        return $this->helpers->apiArrayResponseBuilder(200, 'success', 'Data has been deleted successfully.');
    }

    public function destroy($id){

        $this->ClasseMatiereModel->where('id',$id)->delete();

        return $this->helpers->apiArrayResponseBuilder(200, 'success', 'Data has been deleted successfully.');
    }


    public static function getAfterFilters() {return [];}
    public static function getBeforeFilters() {return [];}
    public static function getMiddleware() {return [];}
    public function callAction($method, $parameters=false) {
        return call_user_func_array(array($this, $method), $parameters);
    }
    
}
