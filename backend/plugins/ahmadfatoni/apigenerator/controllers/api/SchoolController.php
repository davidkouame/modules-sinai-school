<?php namespace AhmadFatoni\ApiGenerator\Controllers\API;

use Cms\Classes\Controller;
use BackendMenu;

use Illuminate\Http\Request;
use AhmadFatoni\ApiGenerator\Helpers\Helpers;
use Illuminate\Support\Facades\Validator;
use BootnetCrasher\School\Models\SchoolModel;
use RainLab\User\Models\User;

class SchoolController extends Controller
{
	protected $SchoolModel;

    protected $helpers;

    public function __construct(SchoolModel $SchoolModel, Helpers $helpers)
    {
        parent::__construct();
        $this->SchoolModel    = $SchoolModel;
        $this->helpers          = $helpers;
    }

    public function index(){

        $data = $this->SchoolModel->all()->toArray();

        return $this->helpers->apiArrayResponseBuilder(200, 'success', $data);
    }

    public function show($id){

        $data = $this->SchoolModel->where('id',$id)->first();

        if( count($data) > 0){

            return $this->helpers->apiArrayResponseBuilder(200, 'success', $data);

        }

        $this->helpers->apiArrayResponseBuilder(400, 'bad request', ['error' => 'invalid key']);

    }

    public function getCustomiseShow($id){
        /*$data = $this->SchoolModel->where('id',$id)->first();

        if( count($data) > 0){

            return $this->helpers->apiArrayResponseBuilder(200, 'success', $data);

        }*/
        $user = User::where('ecole_id', $id)->first();
        $dataCustomize = [
            "username" => $user->name,
            "email" => $user->email
        ];
        return $this->helpers->apiArrayResponseBuilder(200, 'success', $dataCustomize);
    }

    public function store(Request $request){

    	$arr = $request->all();

        while ( $data = current($arr)) {
            $this->SchoolModel->{key($arr)} = $data;
            next($arr);
        }

        $validation = Validator::make($request->all(), $this->SchoolModel->rules);
        
        if($validation->passes() ){
            $this->SchoolModel->save();
            return $this->helpers->apiArrayResponseBuilder(201, 'created', ['id' => $this->SchoolModel->id]);
        }else{
            return $this->helpers->apiArrayResponseBuilder(400, 'fail', $validation->errors() );
        }

    }

    public function update($id, Request $request){

        $status = $this->SchoolModel->where('id',$id)->update($data);
    
        if( $status ){
            
            return $this->helpers->apiArrayResponseBuilder(200, 'success', 'Data has been updated successfully.');

        }else{

            return $this->helpers->apiArrayResponseBuilder(400, 'bad request', 'Error, data failed to update.');

        }
    }

    public function customiseUpdate($id, Request $request){
        $user = User::where('ecole_id', $id)->first();
        $user->name = $request->get('username');
        if($request->get('password') && $request->get('confirmationpassword')){
            $user->password = $request->get('password');
            $user->password_confirmation = $request->get('confirmationpassword');
        }
        $user->save();
        return $this->helpers->apiArrayResponseBuilder(200, 'success', 'Data has been updated successfully.');
    }

    public function delete($id){

        $this->SchoolModel->where('id',$id)->delete();

        return $this->helpers->apiArrayResponseBuilder(200, 'success', 'Data has been deleted successfully.');
    }

    public function destroy($id){

        $this->SchoolModel->where('id',$id)->delete();

        return $this->helpers->apiArrayResponseBuilder(200, 'success', 'Data has been deleted successfully.');
    }


    public static function getAfterFilters() {return [];}
    public static function getBeforeFilters() {return [];}
    public static function getMiddleware() {return [];}
    public function callAction($method, $parameters=false) {
        return call_user_func_array(array($this, $method), $parameters);
    }
    
}