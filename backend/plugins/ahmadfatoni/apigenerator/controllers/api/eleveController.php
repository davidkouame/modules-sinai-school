<?php namespace AhmadFatoni\ApiGenerator\Controllers\API;

use Cms\Classes\Controller;
use BackendMenu;

use Illuminate\Http\Request;
use AhmadFatoni\ApiGenerator\Helpers\Helpers;
use BootnetCrasher\School\Models\EleveModel;
class eleveController extends Controller
{
    protected $EleveModel;

    protected $helpers;

    public function __construct(EleveModel $EleveModel, Helpers $helpers)
    {
        parent::__construct();
        $this->EleveModel    = $EleveModel;
        $this->helpers          = $helpers;
    }

    
    public function index(){ 
        $data = $this->EleveModel->with(array(
            'users'=>function($query){
                $query->select('*');
            },'parent'=>function($query){
                //$query->select('*');
                $query->with(array(
                    'users'=>function($q){
                        $q->select('*');
                    }
                ))->select('*');
            }, ))->select('*')->get()->toArray();
        return $this->helpers->apiArrayResponseBuilder(200, 'success', $data);
    }

    
    public function show($id){
        $data = $this->EleveModel->with(array(
            'users'=>function($query){
                $query->select('*');
            },'parent'=>function($query){
                // $query->select('*');
                $query->with(array(
                    'users'=>function($q){
                        $q->select('*');
                    }
                ))->select('*');
            } ))->select('*')->where('id', '=', $id)->first();
        return $this->helpers->apiArrayResponseBuilder(200, 'success', $data);
    }

    public function store(Request $request){

        $arr = $request->all();

        while ( $data = current($arr)) {
            $this->EleveModel->{key($arr)} = $data;
            next($arr);
        }

        $validation = Validator::make($request->all(), $this->EleveModel->rules);
        
        if( $validation->passes() ){
            $this->EleveModel->save();
            return $this->helpers->apiArrayResponseBuilder(201, 'created', ['id' => $this->EleveModel->id]);
        }else{
            return $this->helpers->apiArrayResponseBuilder(400, 'fail', $validation->errors() );
        }

    }

    public function update($id, Request $request){

        $status = $this->EleveModel->where('id',$id)->update($data);
    
        if( $status ){
            
            return $this->helpers->apiArrayResponseBuilder(200, 'success', 'Data has been updated successfully.');

        }else{

            return $this->helpers->apiArrayResponseBuilder(400, 'bad request', 'Error, data failed to update.');

        }
    }

    public function delete($id){

        $this->EleveModel->where('id',$id)->delete();

        return $this->helpers->apiArrayResponseBuilder(200, 'success', 'Data has been deleted successfully.');
    }

    public function destroy($id){

        $this->EleveModel->where('id',$id)->delete();

        return $this->helpers->apiArrayResponseBuilder(200, 'success', 'Data has been deleted successfully.');
    }


    public static function getAfterFilters() {return [];}
    public static function getBeforeFilters() {return [];}
    public static function getMiddleware() {return [];}
    public function callAction($method, $parameters=false) {
        return call_user_func_array(array($this, $method), $parameters);
    }
    
}
