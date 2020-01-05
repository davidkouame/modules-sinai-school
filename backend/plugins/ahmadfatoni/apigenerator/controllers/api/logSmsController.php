<?php namespace AhmadFatoni\ApiGenerator\Controllers\API;

use Cms\Classes\Controller;
use BackendMenu;

use Illuminate\Http\Request;
use AhmadFatoni\ApiGenerator\Helpers\Helpers;
use BootnetCrasher\School\Models\LogSmsModel;
class logSmsController extends Controller
{
    protected $LogSmsModel;

    protected $helpers;

    public function __construct(LogSmsModel $LogSmsModel, Helpers $helpers)
    {
        parent::__construct();
        $this->LogSmsModel    = $LogSmsModel;
        $this->helpers          = $helpers;
    }

    
    public function index(Request $request){
        $data = $this->LogSmsModel->with(array(
            'parent'=>function($query){
                $query->select('*');
            },
            'eleve'=>function($query){
                $query->select('*');
            }, ));
        if($request->has('search')){
            $date = explode("-", trim($request->get('search')));
            if (count($date) == 3) {
                // $newdate = $date[2] . "-" . $date[1] . "-" . $date[0];
                $data = $data->whereDate("created_at", "=", $request->get('search'));
            }
        }
        if($request->has('page') && $request->get('page') == 0){
            $data = $data->get()->toArray();
        }else{
            $data = $data->paginate(10)->toArray();
        }
        // ->select('*')->get()->toArray();
        return $this->helpers->apiArrayResponseBuilder(200, 'success', $data);
    }

    
    public function show($id){ 
        $data = $this->LogSmsModel->with(array(
            'parent'=>function($query){
                $query->select('*');
            },
            'eleve'=>function($query){
                $query->select('*');
            }, ))->select('*')->where('id', '=', $id)->first();
        return $this->helpers->apiArrayResponseBuilder(200, 'success', $data);
    }

    public function store(Request $request){

        $arr = $request->all();

        while ( $data = current($arr)) {
            $this->LogSmsModel->{key($arr)} = $data;
            next($arr);
        }

        $validation = Validator::make($request->all(), $this->LogSmsModel->rules);
        
        if( $validation->passes() ){
            $this->LogSmsModel->save();
            return $this->helpers->apiArrayResponseBuilder(201, 'created', ['id' => $this->LogSmsModel->id]);
        }else{
            return $this->helpers->apiArrayResponseBuilder(400, 'fail', $validation->errors() );
        }

    }

    public function update($id, Request $request){

        $status = $this->LogSmsModel->where('id',$id)->update($data);
    
        if( $status ){
            
            return $this->helpers->apiArrayResponseBuilder(200, 'success', 'Data has been updated successfully.');

        }else{

            return $this->helpers->apiArrayResponseBuilder(400, 'bad request', 'Error, data failed to update.');

        }
    }

    public function delete($id){

        $this->LogSmsModel->where('id',$id)->delete();

        return $this->helpers->apiArrayResponseBuilder(200, 'success', 'Data has been deleted successfully.');
    }

    public function destroy($id){

        $this->LogSmsModel->where('id',$id)->delete();

        return $this->helpers->apiArrayResponseBuilder(200, 'success', 'Data has been deleted successfully.');
    }


    public static function getAfterFilters() {return [];}
    public static function getBeforeFilters() {return [];}
    public static function getMiddleware() {return [];}
    public function callAction($method, $parameters=false) {
        return call_user_func_array(array($this, $method), $parameters);
    }
    
}
