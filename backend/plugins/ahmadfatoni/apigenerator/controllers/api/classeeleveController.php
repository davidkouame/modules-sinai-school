<?php namespace AhmadFatoni\ApiGenerator\Controllers\API;

use Cms\Classes\Controller;
use BackendMenu;

use Illuminate\Http\Request;
use AhmadFatoni\ApiGenerator\Helpers\Helpers;
use BootnetCrasher\School\Models\ClasseEleveModel;
class classeeleveController extends Controller
{
    protected $ClasseEleveModel;

    protected $helpers;

    public function __construct(ClasseEleveModel $ClasseEleveModel, Helpers $helpers)
    {
        parent::__construct();
        $this->ClasseEleveModel    = $ClasseEleveModel;
        $this->helpers          = $helpers;
    }

    
    public function index(Request $request){
        $data = $this->ClasseEleveModel->with(array(
            'eleve'=>function($query){
                $query->select('*');
            },
            'classe'=>function($query){
                $query->select('*');
            }, )); // ->select('*')->get()->toArray();

        foreach($request->except(['page']) as $key => $value){
            if($key == "libelle"){
                $data = $data->where($key, 'like', '%'.$value.'%');
            }else{
                $data = $data->where($key, $value);
            }
        }

        $data = $data->paginate(10)->toArray();

        return $this->helpers->apiArrayResponseBuilder(200, 'success', $data);
    }

    
    public function show($id){ 
        $data = $this->ClasseEleveModel->with(array(
            'eleve'=>function($query){
                $query->select('*');
            },
            'classe'=>function($query){
                $query->select('*');
            }, ))->select('*')->where('id', '=', $id)->first();
        return $this->helpers->apiArrayResponseBuilder(200, 'success', $data);
    }

    public function store(Request $request){

        $arr = $request->all();

        while ( $data = current($arr)) {
            $this->ClasseEleveModel->{key($arr)} = $data;
            next($arr);
        }

        $validation = Validator::make($request->all(), $this->ClasseEleveModel->rules);
        
        if( $validation->passes() ){
            $this->ClasseEleveModel->save();
            return $this->helpers->apiArrayResponseBuilder(201, 'created', ['id' => $this->ClasseEleveModel->id]);
        }else{
            return $this->helpers->apiArrayResponseBuilder(400, 'fail', $validation->errors() );
        }

    }

    public function update($id, Request $request){

        $status = $this->ClasseEleveModel->where('id',$id)->update($data);
    
        if( $status ){
            
            return $this->helpers->apiArrayResponseBuilder(200, 'success', 'Data has been updated successfully.');

        }else{

            return $this->helpers->apiArrayResponseBuilder(400, 'bad request', 'Error, data failed to update.');

        }
    }

    public function delete($id){

        $this->ClasseEleveModel->where('id',$id)->delete();

        return $this->helpers->apiArrayResponseBuilder(200, 'success', 'Data has been deleted successfully.');
    }

    public function destroy($id){

        $this->ClasseEleveModel->where('id',$id)->delete();

        return $this->helpers->apiArrayResponseBuilder(200, 'success', 'Data has been deleted successfully.');
    }


    public static function getAfterFilters() {return [];}
    public static function getBeforeFilters() {return [];}
    public static function getMiddleware() {return [];}
    public function callAction($method, $parameters=false) {
        return call_user_func_array(array($this, $method), $parameters);
    }
    
}
