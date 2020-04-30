<?php namespace AhmadFatoni\ApiGenerator\Controllers\API;

use Cms\Classes\Controller;
use BackendMenu;

use Illuminate\Http\Request;
use AhmadFatoni\ApiGenerator\Helpers\Helpers;
use Illuminate\Support\Facades\Validator;
use BootnetCrasher\Parametrage\Models\Role;
use BootnetCrasher\Parametrage\Models\PermissionRoleModel;
use Illuminate\Support\Collection;

class RoleController extends Controller
{
	protected $Role;

    protected $helpers;

    public function __construct(Role $Role, Helpers $helpers)
    {
        parent::__construct();
        $this->Role    = $Role;
        $this->helpers          = $helpers;
    }

    public function index(Request $request){
        $data = $this->Role;
        foreach($request->except('page') as $key => $value){
            if($key == "search"){
                $data = $data->where("libelle", 'like', '%'.$value.'%');
            }else{
                $data = $data->where($key, $value);
            }
        }
        if($request->has('page') && $request->get('page') == 0){
            $data = $data->orderBy('created_at', 'desc')->get()->toArray();
        }else{
            $data = $data->orderBy('created_at', 'desc')->paginate(10)->toArray();
        }
        return $this->helpers->apiArrayResponseBuilder(200, 'success', $data);
    }

    public function show($id){
        $data = $this->Role->where('id',$id)->first();
        if($data){
            $permissions = new Collection;
            $permissionsRole = PermissionRoleModel::where('role_id', $id)->get();
            foreach($permissionsRole as $permissionRole){
                $permissions->push($permissionRole->permission);
            }
            $data = $data->toArray();
            $data["permissions"] = $permissions->toArray();
            return $this->helpers->apiArrayResponseBuilder(200, 'success', $data);
        }
        $this->helpers->apiArrayResponseBuilder(400, 'bad request', ['error' => 'invalid key']);
    }

    public function store(Request $request){
        $arr = $request->all();
        $validation = Validator::make($request->all(), $this->Role->rules);
        if($validation->passes() ){
            while ( $data = current($arr)) {
                $this->Role->{key($arr)} = $data;
                next($arr);
            }
            $this->Role->save();
            return $this->helpers->apiArrayResponseBuilder(201, 'created', ['id' => $this->Role->id]);
        }else{
            return $this->helpers->apiArrayResponseBuilder(400, 'fail', $validation->errors() );
        }
    }

    public function update($id, Request $request){
        $validation = Validator::make($request->all(), $this->Role->rules);
        if($validation->passes()){
            $status = $this->Role->where('id',$id)->update($request->except('permissions'));
            if( $status ){
                $role = $this->Role->where('id',$id)->first();
                PermissionRoleModel::where('role_id', $role->id)->delete();
                foreach($request->get('permissions') as $permissionId){
                    $permissionsRole = new PermissionRoleModel;
                    $permissionsRole->permission_id = $permissionId;
                    $permissionsRole->role_id = $role->id;
                    $permissionsRole->save();
                }
                return $this->helpers->apiArrayResponseBuilder(200, 'success', 'Data has been updated successfully.');
            }else{
                return $this->helpers->apiArrayResponseBuilder(400, 'bad request', 'Error, data failed to update.');
            }
        }else{
            return $this->helpers->apiArrayResponseBuilder(400, 'fail', $validation->errors() );
        }
    }

    public function delete($id){

        $this->Role->where('id',$id)->delete();

        return $this->helpers->apiArrayResponseBuilder(200, 'success', 'Data has been deleted successfully.');
    }

    public function destroy($id){

        $this->Role->where('id',$id)->delete();

        return $this->helpers->apiArrayResponseBuilder(200, 'success', 'Data has been deleted successfully.');
    }


    public static function getAfterFilters() {return [];}
    public static function getBeforeFilters() {return [];}
    public static function getMiddleware() {return [];}
    public function callAction($method, $parameters=false) {
        return call_user_func_array(array($this, $method), $parameters);
    }
    
}