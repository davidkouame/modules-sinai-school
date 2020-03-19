<?php namespace AhmadFatoni\ApiGenerator\Controllers\API;

use Cms\Classes\Controller;
use BackendMenu;

use Illuminate\Http\Request;
use AhmadFatoni\ApiGenerator\Helpers\Helpers;
use Illuminate\Support\Facades\Validator;
use BootnetCrasher\Parametrage\Models\PaysModel;
class PaysController extends Controller
{
	protected $PaysModel;

    protected $helpers;

    private $rules = [
        "libelle" => "required",
        "indicatif" => 'required'
    ];
    
    private $messages = [
        "libelle.required" => "Veuillez entre un libellé",
        "indicatif.required" => "Veuillez entrer un indicatif"
    ];

    public function __construct(PaysModel $PaysModel, Helpers $helpers)
    {
        parent::__construct();
        $this->PaysModel    = $PaysModel;
        $this->helpers          = $helpers;
    }

    public function index(){

        $data = $this->PaysModel->orderBy('created_at', 'desc')->all()->toArray();

        return $this->helpers->apiArrayResponseBuilder(200, 'success', $data);
    }

    public function show($id){

        $data = $this->PaysModel->where('id',$id)->first();

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
                $this->PaysModel->{key($arr)} = $data;
                next($arr);
            }
            $this->PaysModel->save();
            return $this->helpers->apiArrayResponseBuilder(201, 'created', ['id' => $this->PaysModel->id]);
        }else{
            return $this->helpers->apiArrayResponseBuilder(400, 'fail', $validation->errors() );
        }
    }

    public function update($id, Request $request){
        $validation = Validator::make($request->all(), $this->rules, $this->messages);
        if($validation->passes()){
            $status = $this->PaysModel->where('id',$id)->update($data);
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

        $this->PaysModel->where('id',$id)->delete();

        return $this->helpers->apiArrayResponseBuilder(200, 'success', 'Data has been deleted successfully.');
    }

    public function destroy($id){

        $this->PaysModel->where('id',$id)->delete();

        return $this->helpers->apiArrayResponseBuilder(200, 'success', 'Data has been deleted successfully.');
    }


    public static function getAfterFilters() {return [];}
    public static function getBeforeFilters() {return [];}
    public static function getMiddleware() {return [];}
    public function callAction($method, $parameters=false) {
        return call_user_func_array(array($this, $method), $parameters);
    }
    
}