<?php namespace AhmadFatoni\ApiGenerator\Controllers\API;

use Cms\Classes\Controller;
use BackendMenu;

use Illuminate\Http\Request;
use AhmadFatoni\ApiGenerator\Helpers\Helpers;
use Illuminate\Support\Facades\Validator;
use BootnetCrasher\Parametrage\Models\PermissionRoleModel;
use DB;

class PermissionRoleController extends Controller
{
	protected $PermissionRoleModel;

    protected $helpers;

    public function __construct(PermissionRoleModel $PermissionRoleModel, Helpers $helpers)
    {
        parent::__construct();
        $this->PermissionRoleModel    = $PermissionRoleModel;
        $this->helpers          = $helpers;
    }

    public function index(Request $request){
        $data = $this->PermissionRoleModel->with(array(
            'permission'=>function($query){
                $query->select('*');
            },
            'role'=>function($query){
                $query->select('*');
            } ))->select('*');
        foreach ($request->except('page') as $key => $value) {
            $data = $data->where($key, $value);
        }
        if($request->has('page') && $request->get('page') == 0){
            $data = $data->orderBy('created_at', 'desc')->get()->toArray();
        }else{
            $data = $data->orderBy('created_at', 'desc')->paginate(10)->toArray();
        }
        return $this->helpers->apiArrayResponseBuilder(200, 'success', $data);
    }

    public function onloadPermissionsCodeByRoleId(Request $request, $role_id){
        $results = DB::table('bootnetcrasher_parametrage_permissions_roles')->
        join('bootnetcrasher_parametrage_permission', 'bootnetcrasher_parametrage_permissions_roles.permission_id', '=', 'bootnetcrasher_parametrage_permission.id')
        ->where('bootnetcrasher_parametrage_permissions_roles.role_id', '=', $role_id)
        ->select('bootnetcrasher_parametrage_permission.code_permission')
        ->get();
        $data = [];
        foreach($results as $result){
            $data[] = $result->code_permission;
        }
        return $this->helpers->apiArrayResponseBuilder(200, 'success', $data);
    }

    public function show($id){

        $data = $this->PermissionRoleModel->where('id',$id)->first();

        if( count($data) > 0){

            return $this->helpers->apiArrayResponseBuilder(200, 'success', $data);

        }

        $this->helpers->apiArrayResponseBuilder(400, 'bad request', ['error' => 'invalid key']);

    }

    public function store(Request $request){

    	$arr = $request->all();

        while ( $data = current($arr)) {
            $this->PermissionRoleModel->{key($arr)} = $data;
            next($arr);
        }

        $validation = Validator::make($request->all(), $this->PermissionRoleModel->rules);
        
        if($validation->passes() ){
            $this->PermissionRoleModel->save();
            return $this->helpers->apiArrayResponseBuilder(201, 'created', ['id' => $this->PermissionRoleModel->id]);
        }else{
            return $this->helpers->apiArrayResponseBuilder(400, 'fail', $validation->errors() );
        }

    }

    public function update($id, Request $request){

        $status = $this->PermissionRoleModel->where('id',$id)->update($data);
    
        if( $status ){
            
            return $this->helpers->apiArrayResponseBuilder(200, 'success', 'Data has been updated successfully.');

        }else{

            return $this->helpers->apiArrayResponseBuilder(400, 'bad request', 'Error, data failed to update.');

        }
    }

    public function delete($id){

        $this->PermissionRoleModel->where('id',$id)->delete();

        return $this->helpers->apiArrayResponseBuilder(200, 'success', 'Data has been deleted successfully.');
    }

    public function destroy($id){

        $this->PermissionRoleModel->where('id',$id)->delete();

        return $this->helpers->apiArrayResponseBuilder(200, 'success', 'Data has been deleted successfully.');
    }


    public static function getAfterFilters() {return [];}
    public static function getBeforeFilters() {return [];}
    public static function getMiddleware() {return [];}
    public function callAction($method, $parameters=false) {
        return call_user_func_array(array($this, $method), $parameters);
    }
    
}