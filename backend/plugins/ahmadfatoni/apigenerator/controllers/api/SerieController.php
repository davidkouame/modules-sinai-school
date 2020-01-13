<?php namespace AhmadFatoni\ApiGenerator\Controllers\API;

use Cms\Classes\Controller;
use BackendMenu;

use Illuminate\Http\Request;
use AhmadFatoni\ApiGenerator\Helpers\Helpers;
use Illuminate\Support\Facades\Validator;
use BootnetCrasher\School\Models\SerieClasseModel;
class SerieController extends Controller
{
	protected $SerieClasseModel;

    protected $helpers;

    public function __construct(SerieClasseModel $SerieClasseModel, Helpers $helpers)
    {
        parent::__construct();
        $this->SerieClasseModel    = $SerieClasseModel;
        $this->helpers          = $helpers;
    }

    public function index(Request $request){
        $data = $this->SerieClasseModel;
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
        $data = $this->SerieClasseModel->where('id',$id)->first();
        if($data){
            return $this->helpers->apiArrayResponseBuilder(200, 'success', $data);
        }
        $this->helpers->apiArrayResponseBuilder(400, 'bad request', ['error' => 'invalid key']);
    }

    public function store(Request $request){

    	$arr = $request->all();

        while ( $data = current($arr)) {
            $this->SerieClasseModel->{key($arr)} = $data;
            next($arr);
        }

        $validation = Validator::make($request->all(), $this->SerieClasseModel->rules);
        
        if( $validation->passes() ){
            $this->SerieClasseModel->save();
            return $this->helpers->apiArrayResponseBuilder(201, 'created', ['id' => $this->SerieClasseModel->id]);
        }else{
            return $this->helpers->apiArrayResponseBuilder(400, 'fail', $validation->errors() );
        }

    }

    public function update($id, Request $request){
        $status = $this->SerieClasseModel->where('id',$id)->update($request->all());
        if( $status ){
            return $this->helpers->apiArrayResponseBuilder(200, 'success', 'Data has been updated successfully.');
        }else{
            return $this->helpers->apiArrayResponseBuilder(400, 'bad request', 'Error, data failed to update.');
        }
    }

    public function delete($id){

        $this->SerieClasseModel->where('id',$id)->delete();

        return $this->helpers->apiArrayResponseBuilder(200, 'success', 'Data has been deleted successfully.');
    }

    public function destroy($id){

        $this->SerieClasseModel->where('id',$id)->delete();

        return $this->helpers->apiArrayResponseBuilder(200, 'success', 'Data has been deleted successfully.');
    }


    public static function getAfterFilters() {return [];}
    public static function getBeforeFilters() {return [];}
    public static function getMiddleware() {return [];}
    public function callAction($method, $parameters=false) {
        return call_user_func_array(array($this, $method), $parameters);
    }
    
}