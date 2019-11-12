<?php namespace AhmadFatoni\ApiGenerator\Controllers\API;

use Cms\Classes\Controller;
use BackendMenu;

use Illuminate\Http\Request;
use AhmadFatoni\ApiGenerator\Helpers\Helpers;
use BootnetCrasher\School\Models\AbsenceEleveModel;
use BootnetCrasher\School\Models\EleveModel;
use Dotenv\Validator;

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

    
    public function index(Request $request){
        $data = $this->AbsenceEleveModel->with(array(
            'raisonabsence'=>function($query){
                $query->select('*');
            },
            'eleve'=>function($query){
                $query->select('*');
            }, )
        );

        $data = $data->whereHas('eleve', function ($query) use($request) {
                    $query->whereHas('classeseleves', function ($q) use($request) {
                        if($request->has('classe_id')){
                            $q->where('classe_id', $request->get('classe_id'));
                        }
                    });
                });

        foreach($request->except('page', 'classe_id') as $key => $value){
            if($key == "parent_id"){
                $data = $data->whereHas('eleve', function ($query) use($request, $key) {
                    $query->where($key,$request->get('parent_id'));
                });
            }else{
                $data = $data->where($key, $value);
            }
        }
        $data = $data->paginate(10)->toArray();
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
        
        if(count($this->AbsenceEleveModel->rules) > 0){
            $validation = Validator::make($request->all(), $this->AbsenceEleveModel->rules);
            if( $validation->passes() ){
                $this->AbsenceEleveModel->save();
                return $this->helpers->apiArrayResponseBuilder(201, 'created', ['id' => $this->AbsenceEleveModel->id]);
            }else{
                return $this->helpers->apiArrayResponseBuilder(400, 'fail', $validation->errors() );
            }
        }else{
            $absenceelevemodel = $this->AbsenceEleveModel->save();
            /*dd($this->AbsenceEleveModel->with(array(
                'raisonabsence'=>function($query){
                    $query->select('*');
                },
                'eleve'=>function($query){
                    $query->select('*');
                }, ))->first()->toArray());*/
            return $this->helpers->apiArrayResponseBuilder(201, 'created', $this->AbsenceEleveModel->toArray()); 
        }
    }

    public function update($id, Request $request){
        // $data = $request->all();
        $data = json_decode($request->getContent(), true);

        $status = $this->AbsenceEleveModel->where('id',$id)->update($data);
    
        if( $status ){
            
            return $this->helpers->apiArrayResponseBuilder(200, 'success', 
            $this->AbsenceEleveModel->where('id',$id)->first()->toArray());

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
