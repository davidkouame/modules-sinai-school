<?php namespace AhmadFatoni\ApiGenerator\Controllers\API;

use Cms\Classes\Controller;
use BackendMenu;

use Illuminate\Http\Request;
use AhmadFatoni\ApiGenerator\Helpers\Helpers;
use BootnetCrasher\School\Models\NoteModel;
class noteController extends Controller
{
    protected $NoteModel;

    protected $helpers;

    public function __construct(NoteModel $NoteModel, Helpers $helpers)
    {
        parent::__construct();
        $this->NoteModel    = $NoteModel;
        $this->helpers          = $helpers;
    }

    
    public function index(){ 
        $data = $this->NoteModel->with(array(
            'typenote'=>function($query){
                $query->select();
            },
            'matiere'=>function($query){
                $query->select();
            }, ))->select('*')->get()->toArray();
        return $this->helpers->apiArrayResponseBuilder(200, 'success', $data);
    }

    
    public function show($id){ 
        $data = $this->NoteModel->with(array(
            'typenote'=>function($query){
                $query->select();
            },
            'matiere'=>function($query){
                $query->select();
            }, ))->select('*')->where('id', '=', $id)->first();
        return $this->helpers->apiArrayResponseBuilder(200, 'success', $data);
    }

    public function store(Request $request){

        $arr = $request->all();

        while ( $data = current($arr)) {
            $this->NoteModel->{key($arr)} = $data;
            next($arr);
        }

        $validation = Validator::make($request->all(), $this->NoteModel->rules);
        
        if( $validation->passes() ){
            $this->NoteModel->save();
            return $this->helpers->apiArrayResponseBuilder(201, 'created', ['id' => $this->NoteModel->id]);
        }else{
            return $this->helpers->apiArrayResponseBuilder(400, 'fail', $validation->errors() );
        }

    }

    public function update($id, Request $request){

        $status = $this->NoteModel->where('id',$id)->update($data);
    
        if( $status ){
            
            return $this->helpers->apiArrayResponseBuilder(200, 'success', 'Data has been updated successfully.');

        }else{

            return $this->helpers->apiArrayResponseBuilder(400, 'bad request', 'Error, data failed to update.');

        }
    }

    public function delete($id){

        $this->NoteModel->where('id',$id)->delete();

        return $this->helpers->apiArrayResponseBuilder(200, 'success', 'Data has been deleted successfully.');
    }

    public function destroy($id){

        $this->NoteModel->where('id',$id)->delete();

        return $this->helpers->apiArrayResponseBuilder(200, 'success', 'Data has been deleted successfully.');
    }


    public static function getAfterFilters() {return [];}
    public static function getBeforeFilters() {return [];}
    public static function getMiddleware() {return [];}
    public function callAction($method, $parameters=false) {
        return call_user_func_array(array($this, $method), $parameters);
    }
    
}
