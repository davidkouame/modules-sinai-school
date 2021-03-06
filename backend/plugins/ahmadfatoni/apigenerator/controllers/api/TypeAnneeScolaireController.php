<?php namespace AhmadFatoni\ApiGenerator\Controllers\API;

use Cms\Classes\Controller;
use BackendMenu;

use Illuminate\Http\Request;
use AhmadFatoni\ApiGenerator\Helpers\Helpers;
use Illuminate\Support\Facades\Validator;
use BootnetCrasher\School\Models\TypeAnneeScolaireModel;
class TypeAnneeScolaireController extends Controller
{
	protected $TypeAnneeScolaireModel;

    protected $helpers;

    private $rules = [
        "libelle" => "required"
    ];
    
    private $messages = [
        "libelle.required" => "Veuillez entrer un libelle",
    ];

    public function __construct(TypeAnneeScolaireModel $TypeAnneeScolaireModel, Helpers $helpers)
    {
        parent::__construct();
        $this->TypeAnneeScolaireModel    = $TypeAnneeScolaireModel;
        $this->helpers          = $helpers;
    }

    public function index(Request $request){
        if($request->has('page') && $request->get('page') == 0)
            $data = $this->TypeAnneeScolaireModel->orderBy('created_at', 'desc')->get()->toArray();
        else
            $data = $this->TypeAnneeScolaireModel->orderBy('created_at', 'desc')->paginate(10)->toArray();
        return $this->helpers->apiArrayResponseBuilder(200, 'success', $data);
    }

    public function show($id){

        $data = $this->TypeAnneeScolaireModel->where('id',$id)->first();

        if( count($data) > 0){

            return $this->helpers->apiArrayResponseBuilder(200, 'success', $data);

        }

        $this->helpers->apiArrayResponseBuilder(400, 'bad request', ['error' => 'invalid key']);

    }

    public function store(Request $request){
    	$arr = $request->all();
        $validation = Validator::make($request->all(), $this->rules, $this->messages);
        if($validation->passes() ){
            while ( $data = current($arr)) {
                $this->TypeAnneeScolaireModel->{key($arr)} = $data;
                next($arr);
            }
            $this->TypeAnneeScolaireModel->save();
            return $this->helpers->apiArrayResponseBuilder(201, 'created', ['id' => $this->TypeAnneeScolaireModel->id]);
        }else{
            return $this->helpers->apiArrayResponseBuilder(400, 'fail', $validation->errors() );
        }
    }

    public function update($id, Request $request){
        $validation = Validator::make($request->all(), $this->rules, $this->messages);
        if($validation->passes()){
            $status = $this->TypeAnneeScolaireModel->where('id',$id)->update($data);
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

        $this->TypeAnneeScolaireModel->where('id',$id)->delete();

        return $this->helpers->apiArrayResponseBuilder(200, 'success', 'Data has been deleted successfully.');
    }

    public function destroy($id){

        $this->TypeAnneeScolaireModel->where('id',$id)->delete();

        return $this->helpers->apiArrayResponseBuilder(200, 'success', 'Data has been deleted successfully.');
    }


    public static function getAfterFilters() {return [];}
    public static function getBeforeFilters() {return [];}
    public static function getMiddleware() {return [];}
    public function callAction($method, $parameters=false) {
        return call_user_func_array(array($this, $method), $parameters);
    }
    
}