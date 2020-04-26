<?php namespace AhmadFatoni\ApiGenerator\Controllers\API;

use Cms\Classes\Controller;
use BackendMenu;

use Illuminate\Http\Request;
use AhmadFatoni\ApiGenerator\Helpers\Helpers;
use BootnetCrasher\School\Models\SouscriptionSchoolModel;
class SouscriptionSchoolController extends Controller
{
    protected $SouscriptionSchoolModel;

    protected $helpers;

    public function __construct(SouscriptionSchoolModel $SouscriptionSchoolModel, Helpers $helpers)
    {
        parent::__construct();
        $this->SouscriptionSchoolModel    = $SouscriptionSchoolModel;
        $this->helpers          = $helpers;
    }

    
    public function index(Request $request){ 
        $data = $this->SouscriptionSchoolModel->with(array(
            'school'=>function($query){
                $query->select('*');
            },
            'anneescolaire'=>function($query){
                $query->select('*');
            },
            'typesouscription'=>function($query){
                $query->select('*');
            }, ))->select('*')->get()->toArray();
        return $this->helpers->apiArrayResponseBuilder(200, 'success', $data);
    }

    
    public function show($id){ 
        $data = $this->SouscriptionSchoolModel->with(array(
            'school'=>function($query){
                $query->select('*');
            },
            'anneescolaire'=>function($query){
                $query->select('*');
            },
            'typesouscription'=>function($query){
                $query->select('*');
            }, ))->select('*')->where('id', '=', $id)->first();
        return $this->helpers->apiArrayResponseBuilder(200, 'success', $data);
    }

    public function store(Request $request){

        $arr = $request->all();

        while ( $data = current($arr)) {
            $this->SouscriptionSchoolModel->{key($arr)} = $data;
            next($arr);
        }

        $validation = Validator::make($request->all(), $this->SouscriptionSchoolModel->rules);
        
        if( $validation->passes() ){
            $this->SouscriptionSchoolModel->save();
            return $this->helpers->apiArrayResponseBuilder(201, 'created', ['id' => $this->SouscriptionSchoolModel->id]);
        }else{
            return $this->helpers->apiArrayResponseBuilder(400, 'fail', $validation->errors() );
        }

    }

    public function update($id, Request $request){

        $status = $this->SouscriptionSchoolModel->where('id',$id)->update($data);
    
        if( $status ){
            
            return $this->helpers->apiArrayResponseBuilder(200, 'success', 'Data has been updated successfully.');

        }else{

            return $this->helpers->apiArrayResponseBuilder(400, 'bad request', 'Error, data failed to update.');

        }
    }

    public function delete($id){

        $this->SouscriptionSchoolModel->where('id',$id)->delete();

        return $this->helpers->apiArrayResponseBuilder(200, 'success', 'Data has been deleted successfully.');
    }

    public function destroy($id){

        $this->SouscriptionSchoolModel->where('id',$id)->delete();

        return $this->helpers->apiArrayResponseBuilder(200, 'success', 'Data has been deleted successfully.');
    }


    public static function getAfterFilters() {return [];}
    public static function getBeforeFilters() {return [];}
    public static function getMiddleware() {return [];}
    public function callAction($method, $parameters=false) {
        return call_user_func_array(array($this, $method), $parameters);
    }
    
}
