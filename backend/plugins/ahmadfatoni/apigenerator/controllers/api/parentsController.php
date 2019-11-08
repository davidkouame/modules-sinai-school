<?php namespace AhmadFatoni\ApiGenerator\Controllers\API;

use Cms\Classes\Controller;
use BackendMenu;

use Illuminate\Http\Request;
use AhmadFatoni\ApiGenerator\Helpers\Helpers;
use BootnetCrasher\School\Models\ParentModel;
class parentsController extends Controller
{
    protected $ParentModel;

    protected $helpers;

    public function __construct(ParentModel $ParentModel, Helpers $helpers)
    {
        parent::__construct();
        $this->ParentModel    = $ParentModel;
        $this->helpers          = $helpers;
    }

    
    public function index(){ 
        $data = $this->ParentModel->with(array(
            'user'=>function($query){
                $query->select('*');
            },
            'eleves'=>function($query){
                $query->with(array(
                    'user' => function($query){
                        $query->select('*');
                    }
                ));
            } ))->select('*')->get()->toArray();
        return $this->helpers->apiArrayResponseBuilder(200, 'success', $data);
    }

    
    public function show($id){ 
        $data = $this->ParentModel->with(array(
            'user'=>function($query){
                $query->select('*');
            },
            'eleves'=>function($query){
                $query->with(array(
                    'user' => function($query){
                        $query->select('*');
                    }
                ));
            },
             ))->select('*')->where('id', '=', $id)->first();
        return $this->helpers->apiArrayResponseBuilder(200, 'success', $data);
    }

    public function store(Request $request){

        $arr = $request->all();

        while ( $data = current($arr)) {
            $this->ParentModel->{key($arr)} = $data;
            next($arr);
        }

        $validation = Validator::make($request->all(), $this->ParentModel->rules);
        
        if( $validation->passes() ){
            $this->ParentModel->save();
            return $this->helpers->apiArrayResponseBuilder(201, 'created', ['id' => $this->ParentModel->id]);
        }else{
            return $this->helpers->apiArrayResponseBuilder(400, 'fail', $validation->errors() );
        }

    }

    public function update($id, Request $request){

        $status = $this->ParentModel->where('id',$id)->update($data);
    
        if( $status ){
            
            return $this->helpers->apiArrayResponseBuilder(200, 'success', 'Data has been updated successfully.');

        }else{

            return $this->helpers->apiArrayResponseBuilder(400, 'bad request', 'Error, data failed to update.');

        }
    }

    public function delete($id){

        $this->ParentModel->where('id',$id)->delete();

        return $this->helpers->apiArrayResponseBuilder(200, 'success', 'Data has been deleted successfully.');
    }

    public function destroy($id){

        $this->ParentModel->where('id',$id)->delete();

        return $this->helpers->apiArrayResponseBuilder(200, 'success', 'Data has been deleted successfully.');
    }


    public static function getAfterFilters() {return [];}
    public static function getBeforeFilters() {return [];}
    public static function getMiddleware() {return [];}
    public function callAction($method, $parameters=false) {
        return call_user_func_array(array($this, $method), $parameters);
    }
    
}