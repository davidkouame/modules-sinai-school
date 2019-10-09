<?php namespace AhmadFatoni\ApiGenerator\Controllers\API;

use Cms\Classes\Controller;
use BackendMenu;

use Illuminate\Http\Request;
use AhmadFatoni\ApiGenerator\Helpers\Helpers;
use Illuminate\Support\Facades\Validator;
use BootnetCrasher\School\Models\ProfesseurClasseModel;
class ProfesseurClasseController extends Controller
{
	protected $ProfesseurClasseModel;

    protected $helpers;

    public function __construct(ProfesseurClasseModel $ProfesseurClasseModel, Helpers $helpers)
    {
        parent::__construct();
        $this->ProfesseurClasseModel    = $ProfesseurClasseModel;
        $this->helpers          = $helpers;
    }

    /*public function index(){

        $data = $this->ProfesseurClasseModel->all()->toArray();

        return $this->helpers->apiArrayResponseBuilder(200, 'success', $data);
    }*/

    public function index(Request $request){

        $data = $this->ProfesseurClasseModel;
        foreach($request->all() as $key => $value){
            $data = $data->where($key, $value);
        }
        $data = $data->with(array(
            'classe'=>function($query){
                $query->select('*');
            },'matiere'=>function($query){
                $query->select('*');
            },'professeur'=>function($query){
                $query->select('*');
            }, ))->select('*')->get()->toArray();

        return $this->helpers->apiArrayResponseBuilder(200, 'success', $data);
    }

    public function show($id){

        $data = $this->ProfesseurClasseModel->where('id',$id)->first();

        if(strlen($data) > 0){

            return $this->helpers->apiArrayResponseBuilder(200, 'success', $data);

        }

        $this->helpers->apiArrayResponseBuilder(400, 'bad request', ['error' => 'invalid key']);

    }

    public function store(Request $request){

    	$arr = $request->all();

        while ( $data = current($arr)) {
            $this->ProfesseurClasseModel->{key($arr)} = $data;
            next($arr);
        }

        $validation = Validator::make($request->all(), $this->ProfesseurClasseModel->rules);
        
        if( $validation->passes() ){
            $this->ProfesseurClasseModel->save();
            return $this->helpers->apiArrayResponseBuilder(201, 'created', ['id' => $this->ProfesseurClasseModel->id]);
        }else{
            return $this->helpers->apiArrayResponseBuilder(400, 'fail', $validation->errors() );
        }

    }

    public function update($id, Request $request){

        $status = $this->ProfesseurClasseModel->where('id',$id)->update($data);
    
        if( $status ){
            
            return $this->helpers->apiArrayResponseBuilder(200, 'success', 'Data has been updated successfully.');

        }else{

            return $this->helpers->apiArrayResponseBuilder(400, 'bad request', 'Error, data failed to update.');

        }
    }

    public function delete($id){

        $this->ProfesseurClasseModel->where('id',$id)->delete();

        return $this->helpers->apiArrayResponseBuilder(200, 'success', 'Data has been deleted successfully.');
    }

    public function destroy($id){

        $this->ProfesseurClasseModel->where('id',$id)->delete();

        return $this->helpers->apiArrayResponseBuilder(200, 'success', 'Data has been deleted successfully.');
    }


    public static function getAfterFilters() {return [];}
    public static function getBeforeFilters() {return [];}
    public static function getMiddleware() {return [];}
    public function callAction($method, $parameters=false) {
        return call_user_func_array(array($this, $method), $parameters);
    }
    
}