<?php namespace AhmadFatoni\ApiGenerator\Controllers\API;

use Cms\Classes\Controller;
use BackendMenu;

use Illuminate\Http\Request;
use AhmadFatoni\ApiGenerator\Helpers\Helpers;
use BootnetCrasher\School\Models\SmsSchoolModel;
class EcoleSmsController extends Controller
{
    protected $SmsSchoolModel;

    protected $helpers;

    public function __construct(SmsSchoolModel $SmsSchoolModel, Helpers $helpers)
    {
        parent::__construct();
        $this->SmsSchoolModel    = $SmsSchoolModel;
        $this->helpers          = $helpers;
    }

    
    public function index(Request $request){ 
        $data = $this->SmsSchoolModel->with(array(
            'school'=>function($query){
                $query->select('*');
            }, ));
        foreach($request->except('page') as $key => $value){
            $data = $data->where($key, $value);
        }
        if($request->has('page') && $request->get('page') == 0){
            $data = $data->orderBy('created_at', 'desc')->get()->toArray();
        }else{
            $data = $data->orderBy('created_at', 'desc')->paginate(10)->toArray();
        }
        return $this->helpers->apiArrayResponseBuilder(200, 'success', $data);
    }

    
    public function show($id){ 
        $data = $this->SmsSchoolModel->with(array(
            'school'=>function($query){
                $query->select('*');
            }, ))->select('*')->where('id', '=', $id)->first();
        return $this->helpers->apiArrayResponseBuilder(200, 'success', $data);
    }

    public function store(Request $request){

        $arr = $request->all();

        while ( $data = current($arr)) {
            $this->SmsSchoolModel->{key($arr)} = $data;
            next($arr);
        }

        $validation = Validator::make($request->all(), $this->SmsSchoolModel->rules);
        
        if( $validation->passes() ){
            $this->SmsSchoolModel->save();
            return $this->helpers->apiArrayResponseBuilder(201, 'created', ['id' => $this->SmsSchoolModel->id]);
        }else{
            return $this->helpers->apiArrayResponseBuilder(400, 'fail', $validation->errors() );
        }

    }

    public function update($id, Request $request){
        // dd($request->all());
        $status = $this->SmsSchoolModel->where('id',$id)->update($request->all());
        if( $status ){
            return $this->helpers->apiArrayResponseBuilder(200, 'success', 'Data has been updated successfully.');
        }else{
            return $this->helpers->apiArrayResponseBuilder(400, 'bad request', 'Error, data failed to update.');
        }
    }

    public function delete($id){

        $this->SmsSchoolModel->where('id',$id)->delete();

        return $this->helpers->apiArrayResponseBuilder(200, 'success', 'Data has been deleted successfully.');
    }

    public function destroy($id){

        $this->SmsSchoolModel->where('id',$id)->delete();

        return $this->helpers->apiArrayResponseBuilder(200, 'success', 'Data has been deleted successfully.');
    }


    public static function getAfterFilters() {return [];}
    public static function getBeforeFilters() {return [];}
    public static function getMiddleware() {return [];}
    public function callAction($method, $parameters=false) {
        return call_user_func_array(array($this, $method), $parameters);
    }
    
}
