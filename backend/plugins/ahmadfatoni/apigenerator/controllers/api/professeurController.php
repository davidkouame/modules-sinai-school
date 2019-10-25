<?php namespace AhmadFatoni\ApiGenerator\Controllers\API;

use Cms\Classes\Controller;
use BackendMenu;

use Illuminate\Http\Request;
use AhmadFatoni\ApiGenerator\Helpers\Helpers;
use Illuminate\Support\Facades\Validator;
use BootnetCrasher\School\Models\ProfesseurModel;
class professeurController extends Controller
{
	protected $ProfesseurModel;

    protected $helpers;

    public function __construct(ProfesseurModel $ProfesseurModel, Helpers $helpers)
    {
        parent::__construct();
        $this->ProfesseurModel    = $ProfesseurModel;
        $this->helpers          = $helpers;
    }

    public function index(){

        $data = $this->ProfesseurModel->all()->toArray();

        return $this->helpers->apiArrayResponseBuilder(200, 'success', $data);
    }

    public function show($id){

        // $data = $this->ProfesseurModel->where('id',$id)->first();
        $data = $this->ProfesseurModel->with(array(
            'users'=>function($query){
                $query->select('*');
            }))->select('*')->where('id', '=', $id)->first();

        if($data){

            return $this->helpers->apiArrayResponseBuilder(200, 'success', $data);

        }

        $this->helpers->apiArrayResponseBuilder(400, 'bad request', ['error' => 'invalid key']);

    }

    public function store(Request $request){

    	$arr = $request->all();

        while ( $data = current($arr)) {
            $this->ProfesseurModel->{key($arr)} = $data;
            next($arr);
        }

        $validation = Validator::make($request->all(), $this->ProfesseurModel->rules);
        
        if( $validation->passes() ){
            $this->ProfesseurModel->save();
            return $this->helpers->apiArrayResponseBuilder(201, 'created', ['id' => $this->ProfesseurModel->id]);
        }else{
            return $this->helpers->apiArrayResponseBuilder(400, 'fail', $validation->errors() );
        }

    }

    public function update($id, Request $request){

        $status = $this->ProfesseurModel->where('id',$id)->update($data);
    
        if( $status ){
            
            return $this->helpers->apiArrayResponseBuilder(200, 'success', 'Data has been updated successfully.');

        }else{

            return $this->helpers->apiArrayResponseBuilder(400, 'bad request', 'Error, data failed to update.');

        }
    }

    public function delete($id){

        $this->ProfesseurModel->where('id',$id)->delete();

        return $this->helpers->apiArrayResponseBuilder(200, 'success', 'Data has been deleted successfully.');
    }

    public function destroy($id){

        $this->ProfesseurModel->where('id',$id)->delete();

        return $this->helpers->apiArrayResponseBuilder(200, 'success', 'Data has been deleted successfully.');
    }


    public static function getAfterFilters() {return [];}
    public static function getBeforeFilters() {return [];}
    public static function getMiddleware() {return [];}
    public function callAction($method, $parameters=false) {
        return call_user_func_array(array($this, $method), $parameters);
    }
    
}