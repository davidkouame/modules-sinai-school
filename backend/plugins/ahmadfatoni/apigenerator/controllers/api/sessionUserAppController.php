<?php namespace AhmadFatoni\ApiGenerator\Controllers\API;

use Cms\Classes\Controller;
use BackendMenu;

use Illuminate\Http\Request;
use AhmadFatoni\ApiGenerator\Helpers\Helpers;
use BootnetCrasher\School\Models\SessionUserAppModel;
use Illuminate\Support\Facades\Validator;

class sessionUserAppController extends Controller
{
    protected $SessionUserAppModel;

    protected $helpers;

    public function __construct(SessionUserAppModel $SessionUserAppModel, Helpers $helpers)
    {
        parent::__construct();
        $this->SessionUserAppModel    = $SessionUserAppModel;
        $this->helpers          = $helpers;
    }

    
    public function index(Request $request){ 
        $data = $this->SessionUserAppModel->with(array(
            'user'=>function($query){
                $query->select('*');
            },
            'anneescolaire'=>function($query){
                $query->select('*');
            }, ));
            
        foreach($request->except(['page']) as $key => $value){
            if($key == "libelle"){
                $data = $data->where($key, 'like', '%'.$value.'%');
            }else{
                $data = $data->where($key, $value);
            }
        }
        
        $data = $data->select('*')->get()->toArray();
            
        return $this->helpers->apiArrayResponseBuilder(200, 'success', $data);
    }

    
    public function show($id){ 
        $data = $this->SessionUserAppModel->with(array(
            'user'=>function($query){
                $query->select('*');
            },
            'anneescolaire'=>function($query){
                $query->select('*');
            }, ))->select('*')->where('id', '=', $id)->first();
        return $this->helpers->apiArrayResponseBuilder(200, 'success', $data);
    }

    public function store(Request $request){

        $arr = $request->all();

        while ( $data = current($arr)) {
            $this->SessionUserAppModel->{key($arr)} = $data;
            next($arr);
        }

        $validation = Validator::make($request->all(), $this->SessionUserAppModel->rules);
        
        if( $validation->passes() ){
            $this->SessionUserAppModel->save();
            return $this->helpers->apiArrayResponseBuilder(201, 'created', ['id' => $this->SessionUserAppModel->id]);
        }else{
            return $this->helpers->apiArrayResponseBuilder(400, 'fail', $validation->errors() );
        }

    }

    public function update($id, Request $request){
       
        $status = $this->SessionUserAppModel->where('id',$id)->update($request->all());
    
        if( $status ){
            
            return $this->helpers->apiArrayResponseBuilder(200, 'success', 'Data has been updated successfully.');

        }else{

            return $this->helpers->apiArrayResponseBuilder(400, 'bad request', 'Error, data failed to update.');

        }
    }

    public function delete($id){

        $this->SessionUserAppModel->where('id',$id)->delete();

        return $this->helpers->apiArrayResponseBuilder(200, 'success', 'Data has been deleted successfully.');
    }

    public function destroy($id){

        $this->SessionUserAppModel->where('id',$id)->delete();

        return $this->helpers->apiArrayResponseBuilder(200, 'success', 'Data has been deleted successfully.');
    }


    public static function getAfterFilters() {return [];}
    public static function getBeforeFilters() {return [];}
    public static function getMiddleware() {return [];}
    public function callAction($method, $parameters=false) {
        return call_user_func_array(array($this, $method), $parameters);
    }
    
}
