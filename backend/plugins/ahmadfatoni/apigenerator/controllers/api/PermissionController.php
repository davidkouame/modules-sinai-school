<?php namespace AhmadFatoni\ApiGenerator\Controllers\API;

use Cms\Classes\Controller;
use BackendMenu;

use Illuminate\Http\Request;
use AhmadFatoni\ApiGenerator\Helpers\Helpers;
use BootnetCrasher\Parametrage\Models\PermissionModel;
use BootnetCrasher\Parametrage\Models\PermissionMenuModel;
use Illuminate\Support\Collection;
use DB;

class PermissionController extends Controller
{
    protected $PermissionModel;

    protected $helpers;

    public function __construct(PermissionModel $PermissionModel, Helpers $helpers)
    {
        parent::__construct();
        $this->PermissionModel    = $PermissionModel;
        $this->helpers          = $helpers;
    }
    
    /*public function index(Request $request){ 
        $data = $this->PermissionModel->with(array(
            'permissionmenu'=>function($query){
                $query->select('*');
            }, ))->select('*');
        foreach ($request->except('page') as $key => $value) {
            $data = $data->where($key, $value);
        }
        if($request->has('page') && $request->get('page') == 0){
            $data = $data->orderBy('ordre', 'asc')->get()->toArray();
        }else{
            $data = $data->orderBy('ordre', 'asc')->paginate(10)->toArray();
        }
        return $this->helpers->apiArrayResponseBuilder(200, 'success', $data);
    }*/

    public function index(){
        $data = new Collection;
        $permissions = new Collection;
        $menupermissions = PermissionMenuModel::all();
        foreach($menupermissions as $menupermission){
            $perm = PermissionModel::where('permission_menu_id', $menupermission->id)->get();
            $permissions->put($menupermission->libelle, $perm);
        }
        $data->put("menus", $menupermissions);
        $data->put("permissions", $permissions);
        return $this->helpers->apiArrayResponseBuilder(200, 'success', $data);
    }
    
    public function show($id){ 
        $data = $this->PermissionModel->with(array(
            'permissionmenu'=>function($query){
                $query->select('*');
            }, ))->select('*')->where('id', '=', $id)->first();
        return $this->helpers->apiArrayResponseBuilder(200, 'success', $data);
    }

    public function store(Request $request){

        $arr = $request->all();

        while ( $data = current($arr)) {
            $this->PermissionModel->{key($arr)} = $data;
            next($arr);
        }

        $validation = Validator::make($request->all(), $this->PermissionModel->rules);
        
        if($validation->passes() ){
            $this->PermissionModel->save();
            return $this->helpers->apiArrayResponseBuilder(201, 'created', ['id' => $this->PermissionModel->id]);
        }else{
            return $this->helpers->apiArrayResponseBuilder(400, 'fail', $validation->errors() );
        }

    }

    public function update($id, Request $request){

        $status = $this->PermissionModel->where('id',$id)->update($data);
    
        if( $status ){
            
            return $this->helpers->apiArrayResponseBuilder(200, 'success', 'Data has been updated successfully.');

        }else{

            return $this->helpers->apiArrayResponseBuilder(400, 'bad request', 'Error, data failed to update.');

        }
    }

    public function delete($id){

        $this->PermissionModel->where('id',$id)->delete();

        return $this->helpers->apiArrayResponseBuilder(200, 'success', 'Data has been deleted successfully.');
    }

    public function destroy($id){

        $this->PermissionModel->where('id',$id)->delete();

        return $this->helpers->apiArrayResponseBuilder(200, 'success', 'Data has been deleted successfully.');
    }


    public static function getAfterFilters() {return [];}
    public static function getBeforeFilters() {return [];}
    public static function getMiddleware() {return [];}
    public function callAction($method, $parameters=false) {
        return call_user_func_array(array($this, $method), $parameters);
    }
    
}
