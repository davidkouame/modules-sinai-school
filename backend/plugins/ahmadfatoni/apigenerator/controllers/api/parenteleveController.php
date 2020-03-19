<?php namespace AhmadFatoni\ApiGenerator\Controllers\API;

use Cms\Classes\Controller;
use BackendMenu;

use Illuminate\Http\Request;
use AhmadFatoni\ApiGenerator\Helpers\Helpers;
use Illuminate\Support\Facades\Validator;
use BootnetCrasher\School\Models\ParentEleve;
class parenteleveController extends Controller
{
	protected $ParentEleve;

    protected $helpers;

    private $rules = [
        "name" => "required",
        "tel" => 'required',
        "email" => 'required',
        "datenaissance" => 'required',
        "pays_id" => 'required',
    ];
    
    private $messages = [
        "name.required" => "Veuillez entre un nom",
        "tel.required" => "Veuillez entrer un numéros",
        "email.required" => "Veuillez entrer un email",
        "datenaissance.required" => "Veuillez entrer une date de naissance",
        "pays_id.required" => "Veuillez entrer un pays",
    ];

    public function __construct(ParentEleve $ParentEleve, Helpers $helpers)
    {
        parent::__construct();
        $this->ParentEleve    = $ParentEleve;
        $this->helpers          = $helpers;
    }

    public function index(){

        $data = $this->ParentEleve->orderBy('created_at', 'desc')->all()->toArray();

        return $this->helpers->apiArrayResponseBuilder(200, 'success', $data);
    }

    public function show($id){

        $data = $this->ParentEleve->where('id',$id)->first();

        if( count($data) > 0){

            return $this->helpers->apiArrayResponseBuilder(200, 'success', $data);

        }

        $this->helpers->apiArrayResponseBuilder(400, 'bad request', ['error' => 'invalid key']);

    }

    public function store(Request $request){
    	$arr = $request->all();
        $validation = Validator::make($request->all(), $this->rules, $this->messages);
        if( $validation->passes() ){
            while ( $data = current($arr)) {
                $this->ParentEleve->{key($arr)} = $data;
                next($arr);
            }
            $this->ParentEleve->save();
            return $this->helpers->apiArrayResponseBuilder(201, 'created', ['id' => $this->ParentEleve->id]);
        }else{
            return $this->helpers->apiArrayResponseBuilder(400, 'fail', $validation->errors() );
        }
    }

    public function update($id, Request $request){
        $validation = Validator::make($request->all(), $this->rules, $this->messages);
        if($validation->passes()){
            $status = $this->ParentEleve->where('id',$id)->update($data);
            if( $status ){
                return $this->helpers->apiArrayResponseBuilder(200, 'success', 'Data has been updated successfully.');
            }else{
                return $this->helpers->apiArrayResponseBuilder(400, 'bad request', 'Error, data failed to update.');
            }
        }else{
            return $this->helpers->apiArrayResponseBuilder(400, 'fail', $validation->errors() );
        }
    }

    public function delete($id){

        $this->ParentEleve->where('id',$id)->delete();

        return $this->helpers->apiArrayResponseBuilder(200, 'success', 'Data has been deleted successfully.');
    }

    public function destroy($id){

        $this->ParentEleve->where('id',$id)->delete();

        return $this->helpers->apiArrayResponseBuilder(200, 'success', 'Data has been deleted successfully.');
    }


    public static function getAfterFilters() {return [];}
    public static function getBeforeFilters() {return [];}
    public static function getMiddleware() {return [];}
    public function callAction($method, $parameters=false) {
        return call_user_func_array(array($this, $method), $parameters);
    }
    
}