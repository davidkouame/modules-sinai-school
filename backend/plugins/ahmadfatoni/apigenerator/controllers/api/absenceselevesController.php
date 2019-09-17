<?php namespace AhmadFatoni\ApiGenerator\Controllers\API;

use Cms\Classes\Controller;
use BackendMenu;

use Illuminate\Http\Request;
use AhmadFatoni\ApiGenerator\Helpers\Helpers;
use BootnetCrasher\School\Models\AbsenceEleveModel;
class absenceselevesController extends Controller
{
    protected $AbsenceEleveModel;

    protected $helpers;

    public function __construct(AbsenceEleveModel $AbsenceEleveModel, Helpers $helpers)
    {
        parent::__construct();
        $this->AbsenceEleveModel    = $AbsenceEleveModel;
        $this->helpers          = $helpers;
    }

    
    public function index(){
        $dataGet = get();
        $query = $this->AbsenceEleveModel->with(array(
            'raisonabsence'=>function($query){
                $query->select('*');
            },
            'eleve'=>function($query){
                $query->select('*');
            }, )
        );
        foreach($dataGet as $key => $data) {
            if($key != 'page'){
                $query->where($key, $data);
            } 
        }
        $data = $query->paginate(2)->toArray();
        return $this->helpers->apiArrayResponseBuilder(200, 'success', $data);
    }

    
    public function show($id){ 
        $data = $this->AbsenceEleveModel->with(array(
            'raisonabsence'=>function($query){
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
            $this->AbsenceEleveModel->{key($arr)} = $data;
            next($arr);
        }

        $validation = Validator::make($request->all(), $this->AbsenceEleveModel->rules);
        
        if( $validation->passes() ){
            $this->AbsenceEleveModel->save();
            return $this->helpers->apiArrayResponseBuilder(201, 'created', ['id' => $this->AbsenceEleveModel->id]);
        }else{
            return $this->helpers->apiArrayResponseBuilder(400, 'fail', $validation->errors() );
        }

    }

    public function update($id, Request $request){

        $status = $this->AbsenceEleveModel->where('id',$id)->update($data);
    
        if( $status ){
            
            return $this->helpers->apiArrayResponseBuilder(200, 'success', 'Data has been updated successfully.');

        }else{

            return $this->helpers->apiArrayResponseBuilder(400, 'bad request', 'Error, data failed to update.');

        }
    }

    public function delete($id){

        $this->AbsenceEleveModel->where('id',$id)->delete();

        return $this->helpers->apiArrayResponseBuilder(200, 'success', 'Data has been deleted successfully.');
    }

    public function destroy($id){

        $this->AbsenceEleveModel->where('id',$id)->delete();

        return $this->helpers->apiArrayResponseBuilder(200, 'success', 'Data has been deleted successfully.');
    }


    public static function getAfterFilters() {return [];}
    public static function getBeforeFilters() {return [];}
    public static function getMiddleware() {return [];}
    public function callAction($method, $parameters=false) {
        return call_user_func_array(array($this, $method), $parameters);
    }
    
}
