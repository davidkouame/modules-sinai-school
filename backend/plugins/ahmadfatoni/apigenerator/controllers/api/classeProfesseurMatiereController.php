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
            $data = $data->get()->unique('classe_id')->toArray();
        }elseif($searchEleve){
            $data = $data->get()->unique('matiere_id')->toArray();
        }else{
            $data = $data->get()->toArray();
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

        while ( $data = current($arr)) {
            $this->ClasseMatiereModel->{key($arr)} = $data;
            next($arr);
        }

        $validation = Validator::make($request->all(), $this->ClasseMatiereModel->rules);
        
        if( $validation->passes() ){
            $this->ClasseMatiereModel->save();
            return $this->helpers->apiArrayResponseBuilder(201, 'created', ['id' => $this->ClasseMatiereModel->id]);
        }else{
            return $this->helpers->apiArrayResponseBuilder(400, 'fail', $validation->errors() );
        }

    }

    public function update($id, Request $request){
        $status = $this->ClasseMatiereModel->where('id',$id)->update($request->all());
        if( $status ){
            return $this->helpers->apiArrayResponseBuilder(200, 'success', 'Data has been updated successfully.');
        }else{
            return $this->helpers->apiArrayResponseBuilder(400, 'bad request', 'Error, data failed to update.');
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
