<?php namespace AhmadFatoni\ApiGenerator\Controllers\API;

use Cms\Classes\Controller;
use BackendMenu;

use Illuminate\Http\Request;
use AhmadFatoni\ApiGenerator\Helpers\Helpers;
use BootnetCrasher\School\Models\ClasseModel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;

class classesController extends Controller
{
    protected $ClasseModel;

    protected $helpers;

    private $rules = [
        "libelle" => "required",
        "niveau_id" => 'required',
        "serie_id" => 'required',
        "annee_scolaire_id" => 'required'
    ];
    
    private $messages = [
        "libelle.required" => "Veuillez entrer un libellé",
        "niveau_id.required" => "Veuillez entrer un niveau",
        "serie_id.required" => "Veuillez sélectionner une serie",
        "annee_scolaire_id.required" => "Veuillez sélectionner une année scolaire",
    ];

    public function __construct(ClasseModel $ClasseModel, Helpers $helpers)
    {
        parent::__construct();
        $this->ClasseModel    = $ClasseModel;
        $this->helpers          = $helpers;
    }

    
    public function index(Request $request){
        $data = $this->ClasseModel->with(array(
            'niveau'=>function($query){
                $query->select('*');
            },
            'serie'=>function($query){
                $query->select('*');
            }, ));
        foreach($request->except(['page']) as $key => $value){
            if($request->has('search')){
                $data = $data->where("libelle", 'like', '%'.$request->get('search').'%');
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

    
    public function show($id){ 
        $data = $this->ClasseModel->with(array(
            'niveau'=>function($query){
                $query->select('*');
            },
            'serie'=>function($query){
                $query->select('*');
            },
            'anneescolaire'=>function($query){
                $query->select('*');
            },))->select('*')->where('id', '=', $id)->first();
            if($data and $data->emploisdutemps){
                $emploisdutemps = base64_encode($data->emploisdutemps->getContents());
                $data->emploitemps = $emploisdutemps;
            }

            // dd($data);
            // Storage::disk('local')->put("test.txt", $emploisdutemps);
        return $this->helpers->apiArrayResponseBuilder(200, 'success', $data);
    }

    public function store(Request $request){
        $arr = $request->all();
        $validation = Validator::make($arr, $this->rules, $this->messages);
        if( $validation->passes() ){
            while ( $data = current($arr)) {
                $this->ClasseModel->{key($arr)} = $data;
                next($arr);
            }
            $this->ClasseModel->save();
            return $this->helpers->apiArrayResponseBuilder(201, 'created', ['id' => $this->ClasseModel->id]);
        }else{
            return $this->helpers->apiArrayResponseBuilder(400, 'fail', $validation->errors() );
        }
    }

    public function update($id, Request $request){
        $validation = Validator::make($request->all(), $this->rules, $this->messages);
        if($validation->passes()){
            $status = $this->ClasseModel->where('id',$id)->update($request->all());
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

        $this->ClasseModel->where('id',$id)->delete();

        return $this->helpers->apiArrayResponseBuilder(200, 'success', 'Data has been deleted successfully.');
    }

    public function destroy($id){

        $this->ClasseModel->where('id',$id)->delete();

        return $this->helpers->apiArrayResponseBuilder(200, 'success', 'Data has been deleted successfully.');
    }

    /* Get all élèves by classe id*/
    public function getAllEleves($id = null){
        // try{
            $classe = ClasseModel::with(array(
            'eleves'=>function($query){
                $query->with(array(
                    'eleve'=>function($q){
                        $q->select('*');
                    }
                ));
            }
            ))->where('id', $id)->first();
            $eleves = new Collection;
            //dd($classe);
            if($classe){
                $classe->eleves->each(function($e) use($eleves) {
                    $eleves->push($e->eleve);
                });
                $eleves = $eleves->toArray();
                return $this->helpers->apiArrayResponseBuilder(200, 'success', $eleves);
            }else{
                return $this->helpers->apiArrayResponseBuilder(200, 'success', []);
            }
        /*}catch(Exception $e){
            $nameFile = dirname(__FILE__);
            trace_log("NameFile : ".$nameFile."Erreur lors de la recuperation des élèves, error : ".$e->getMessage());
            return $this->helpers->apiArrayResponseBuilder(500, 'error', 'Erreur lors de la recuperation des élèves.', $e->getMessage());
        }*/
    }


    public static function getAfterFilters() {return [];}
    public static function getBeforeFilters() {return [];}
    public static function getMiddleware() {return [];}
    public function callAction($method, $parameters=false) {
        return call_user_func_array(array($this, $method), $parameters);
    }
    
}
