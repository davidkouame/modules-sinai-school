<?php namespace AhmadFatoni\ApiGenerator\Controllers\API;

use Cms\Classes\Controller;
use BackendMenu;

use Illuminate\Http\Request;
use AhmadFatoni\ApiGenerator\Helpers\Helpers;
use BootnetCrasher\Parametrage\Models\UsersGroups;
class UsersGroupsController extends Controller
{
    protected $UsersGroups;

    protected $helpers;

    public function __construct(UsersGroups $UsersGroups, Helpers $helpers)
    {
        parent::__construct();
        $this->UsersGroups    = $UsersGroups;
        $this->helpers          = $helpers;
    }

    
    public function index(){ 
        $data = $this->UsersGroups->with(array(
            'user'=>function($query){
                $query->select('*');
            },
            'group'=>function($query){
                $query->select('*');
            }, ))->select('*')->get()->toArray();
        return $this->helpers->apiArrayResponseBuilder(200, 'success', $data);
    }

    
    public function show($id){ 
        $data = $this->UsersGroups->with(array(
            'user'=>function($query){
                $query->select('*');
            },
            'group'=>function($query){
                $query->select('*');
            }, ))->select('*')->where('id', '=', $id)->first();
        return $this->helpers->apiArrayResponseBuilder(200, 'success', $data);
    }

    public function store(Request $request){

        $arr = $request->all();

        while ( $data = current($arr)) {
            $this->UsersGroups->{key($arr)} = $data;
            next($arr);
        }

        $validation = Validator::make($request->all(), $this->UsersGroups->rules);
        
        if($validation->passes() ){
            $this->UsersGroups->save();
            return $this->helpers->apiArrayResponseBuilder(201, 'created', ['id' => $this->UsersGroups->id]);
        }else{
            return $this->helpers->apiArrayResponseBuilder(400, 'fail', $validation->errors() );
        }

    }

    public function update($id, Request $request){

        $status = $this->UsersGroups->where('id',$id)->update($data);
    
        if( $status ){
            
            return $this->helpers->apiArrayResponseBuilder(200, 'success', 'Data has been updated successfully.');

        }else{

            return $this->helpers->apiArrayResponseBuilder(400, 'bad request', 'Error, data failed to update.');

        }
    }

    public function delete($id){

        $this->UsersGroups->where('id',$id)->delete();

        return $this->helpers->apiArrayResponseBuilder(200, 'success', 'Data has been deleted successfully.');
    }

    public function destroy($id){

        $this->UsersGroups->where('id',$id)->delete();

        return $this->helpers->apiArrayResponseBuilder(200, 'success', 'Data has been deleted successfully.');
    }


    public static function getAfterFilters() {return [];}
    public static function getBeforeFilters() {return [];}
    public static function getMiddleware() {return [];}
    public function callAction($method, $parameters=false) {
        return call_user_func_array(array($this, $method), $parameters);
    }
    
}
