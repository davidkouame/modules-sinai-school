<?php namespace AhmadFatoni\ApiGenerator\Controllers\API;

use Cms\Classes\Controller;
use BackendMenu;

use Illuminate\Http\Request;
use AhmadFatoni\ApiGenerator\Helpers\Helpers;
use BootnetCrasher\School\Models\ClasseModel;
use Illuminate\Support\Facades\Storage;

class classesController extends Controller
{
    protected $ClasseModel;

    protected $helpers;

    public function __construct(ClasseModel $ClasseModel, Helpers $helpers)
    {
        parent::__construct();
        $this->ClasseModel    = $ClasseModel;
        $this->helpers          = $helpers;
    }

    
    public function index(){ 
        $data = $this->ClasseModel->with(array(
            'niveau'=>function($query){
                $query->select('*');
            },
            'serie'=>function($query){
                $query->select('*');
            }, ))->select('*')->get()->toArray();
        return $this->helpers->apiArrayResponseBuilder(200, 'success', $data);
    }

    
    public function show($id){ 
        $data = $this->ClasseModel->with(array(
            'niveau'=>function($query){
                $query->select('*');
            },
            'serie'=>function($query){
                $query->select('*');
            }, ))->select('*')->where('id', '=', $id)->first();
            $emploisdutemps = base64_encode($data->emploisdutemps->getContents());
            $data->emploitemps = $emploisdutemps;
            // dd($data);
            // Storage::disk('local')->put("test.txt", $emploisdutemps);
        return $this->helpers->apiArrayResponseBuilder(200, 'success', $data);
    }

    public function store(Request $request){

        $arr = $request->all();

        while ( $data = current($arr)) {
            $this->ClasseModel->{key($arr)} = $data;
            next($arr);
        }

        $validation = Validator::make($request->all(), $this->ClasseModel->rules);
        
        if( $validation->passes() ){
            $this->ClasseModel->save();
            return $this->helpers->apiArrayResponseBuilder(201, 'created', ['id' => $this->ClasseModel->id]);
        }else{
            return $this->helpers->apiArrayResponseBuilder(400, 'fail', $validation->errors() );
        }

    }

    public function update($id, Request $request){

        $status = $this->ClasseModel->where('id',$id)->update($data);
    
        if( $status ){
            
            return $this->helpers->apiArrayResponseBuilder(200, 'success', 'Data has been updated successfully.');

        }else{

            return $this->helpers->apiArrayResponseBuilder(400, 'bad request', 'Error, data failed to update.');

        }
    }

    public function delete($id){

        $this->ClasseModel->where('id',$id)->delete();

        return $this->helpers->apiArrayResponseBuilder(200, 'success', 'Data has been deleted successfully.');
    }

    public function destroy($id){

        $this->ClasseModel->where('id',$id)->delete();

        return $this->helpers->apiArrayResponseBuilder(200, 'success', 'Data has been deleted successfully.');
    }


    public static function getAfterFilters() {return [];}
    public static function getBeforeFilters() {return [];}
    public static function getMiddleware() {return [];}
    public function callAction($method, $parameters=false) {
        return call_user_func_array(array($this, $method), $parameters);
    }
    
}
