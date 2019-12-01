<?php namespace AhmadFatoni\ApiGenerator\Controllers\API;

use Cms\Classes\Controller;
use BackendMenu;

use Illuminate\Http\Request;
use AhmadFatoni\ApiGenerator\Helpers\Helpers;
use Illuminate\Support\Facades\Validator;
use BootnetCrasher\School\Models\MatiereModel;
use BootnetCrasher\School\Models\ClasseEleveModel;
class matiereController extends Controller
{
	protected $MatiereModel;

    protected $helpers;

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

        $data = $data->paginate(10)->toArray();

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
            }
        ))->where('id',$id)->first();

        if($data){

            return $this->helpers->apiArrayResponseBuilder(200, 'success', $data);

        }

        $this->helpers->apiArrayResponseBuilder(400, 'bad request', ['error' => 'invalid key']);

    }

    public function store(Request $request){

    	$arr = $request->all();

        while ( $data = current($arr)) {
            $this->MatiereModel->{key($arr)} = $data;
            next($arr);
        }

        $validation = Validator::make($request->all(), $this->MatiereModel->rules);
        
        if( $validation->passes() ){
            $this->MatiereModel->save();
            return $this->helpers->apiArrayResponseBuilder(201, 'created', ['id' => $this->MatiereModel->id]);
        }else{
            return $this->helpers->apiArrayResponseBuilder(400, 'fail', $validation->errors() );
        }

    }

    public function update($id, Request $request){

        $status = $this->MatiereModel->where('id',$id)->update($data);
    
        if( $status ){
            
            return $this->helpers->apiArrayResponseBuilder(200, 'success', 'Data has been updated successfully.');

        }else{

            return $this->helpers->apiArrayResponseBuilder(400, 'bad request', 'Error, data failed to update.');

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


    public static function getAfterFilters() {return [];}
    public static function getBeforeFilters() {return [];}
    public static function getMiddleware() {return [];}
    public function callAction($method, $parameters=false) {
        return call_user_func_array(array($this, $method), $parameters);
    }
    
}