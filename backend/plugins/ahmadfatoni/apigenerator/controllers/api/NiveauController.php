<?php namespace AhmadFatoni\ApiGenerator\Controllers\API;

use Cms\Classes\Controller;
use BackendMenu;

use Illuminate\Http\Request;
use AhmadFatoni\ApiGenerator\Helpers\Helpers;
use Illuminate\Support\Facades\Validator;
use BootnetCrasher\School\Models\NiveauClasseModel;
class NiveauController extends Controller
{
	protected $NiveauClasseModel;

    protected $helpers;

    public function __construct(NiveauClasseModel $NiveauClasseModel, Helpers $helpers)
    {
        parent::__construct();
        $this->NiveauClasseModel    = $NiveauClasseModel;
        $this->helpers          = $helpers;
    }

    public function index(Request $request){
        $data = $this->NiveauClasseModel;
        if($request->has('search')){
            $data = $data->where("libelle", 'like', '%'.$request->get('search').'%');
        }
        if($request->has('page') && $request->get('page') == 0){
            $data = $data->get()->toArray();
        }else{
            $data = $data->paginate(10)->toArray();
        }
        return $this->helpers->apiArrayResponseBuilder(200, 'success', $data);
    }

    public function show($id){
        $data = $this->NiveauClasseModel->where('id',$id)->first();
        if($data){
            return $this->helpers->apiArrayResponseBuilder(200, 'success', $data);
        }
        $this->helpers->apiArrayResponseBuilder(400, 'bad request', ['error' => 'invalid key']);
    }

    public function store(Request $request){

    	$arr = $request->all();

        while ( $data = current($arr)) {
            $this->NiveauClasseModel->{key($arr)} = $data;
            next($arr);
        }

        $validation = Validator::make($request->all(), $this->NiveauClasseModel->rules);
        
        if( $validation->passes() ){
            $this->NiveauClasseModel->save();
            return $this->helpers->apiArrayResponseBuilder(201, 'created', ['id' => $this->NiveauClasseModel->id]);
        }else{
            return $this->helpers->apiArrayResponseBuilder(400, 'fail', $validation->errors() );
        }

    }

    public function update($id, Request $request){
        $status = $this->NiveauClasseModel->where('id',$id)->update($request->all());
        if( $status ){
            return $this->helpers->apiArrayResponseBuilder(200, 'success', 'Data has been updated successfully.');
        }else{
            return $this->helpers->apiArrayResponseBuilder(400, 'bad request', 'Error, data failed to update.');
        }
    }

    public function delete($id){

        $this->NiveauClasseModel->where('id',$id)->delete();

        return $this->helpers->apiArrayResponseBuilder(200, 'success', 'Data has been deleted successfully.');
    }

    public function destroy($id){

        $this->NiveauClasseModel->where('id',$id)->delete();

        return $this->helpers->apiArrayResponseBuilder(200, 'success', 'Data has been deleted successfully.');
    }


    public static function getAfterFilters() {return [];}
    public static function getBeforeFilters() {return [];}
    public static function getMiddleware() {return [];}
    public function callAction($method, $parameters=false) {
        return call_user_func_array(array($this, $method), $parameters);
    }
    
}