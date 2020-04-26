<?php namespace AhmadFatoni\ApiGenerator\Controllers\API;

use Cms\Classes\Controller;
use BackendMenu;

use Illuminate\Http\Request;
use AhmadFatoni\ApiGenerator\Helpers\Helpers;
use BootnetCrasher\School\Models\SectionAnneeScolaireModel;
use Illuminate\Support\Facades\Validator;
class sectionAnneeScolaireController extends Controller
{
    protected $SectionAnneeScolaireModel;

    protected $helpers;

    private $rules = [
        "libelle" => "required",
        "annee_scolaire_id" => "required",
        "coefficient" => "required",
        "start" => "required",
        "end" => "required",
    ];
    
    private $messages = [
        "libelle.required" => "Veuillez entrer un libellé",
        "annee_scolaire_id.required" => "Veuillez entrer une année scolaire",
        "coefficient.required" => "Veuillez entrer un coefficient",
        "start.required" => "Veuillez entrer une date de début la section",
        "end.required" => "Veuillez entrer une date de fin de la section",
    ];

    public function __construct(SectionAnneeScolaireModel $SectionAnneeScolaireModel, Helpers $helpers)
    {
        parent::__construct();
        $this->SectionAnneeScolaireModel    = $SectionAnneeScolaireModel;
        $this->helpers          = $helpers;
    }

    
    public function index(Request $request){ 
        $data = $this->SectionAnneeScolaireModel->with(array(
            'anneescolaire'=>function($query){
                $query->select();
            }, ));
        foreach($request->except(['page']) as $key => $value){
            if($key == "libelle"){
                $data = $data->where($key, 'like', '%'.$value.'%');
            }else if($key == "search"){
                $data = $data->where("libelle", 'like', '%'.$value.'%');
            }else{
                $data = $data->where($key, $value);
            }
        }
        if($request->has('page') && $request->get('page') == 0){
            $data = $data->orderBy('created_at', 'desc')->get()->toArray();
        }else{
            $data = $data->orderBy('created_at', 'desc')->paginate(10)->toArray();
        }
        return $this->helpers->apiArrayResponseBuilder(200, 'success', $data);
    }

    
    public function show($id){ 
        $data = $this->SectionAnneeScolaireModel->with(array(
            'anneescolaire'=>function($query){
                $query->select();
            }, ))->select('*')->where('id', '=', $id)->first();
        return $this->helpers->apiArrayResponseBuilder(200, 'success', $data);
    }

    public function store(Request $request){
        $arr = $request->all();
        $validation = Validator::make($request->all(), $this->rules, $this->messages);
        if( $validation->passes() ){
            while ( $data = current($arr)) {
                $this->SectionAnneeScolaireModel->{key($arr)} = $data;
                next($arr);
            }
            $this->SectionAnneeScolaireModel->annee_scolaire_id = $request->get('annee_scolaire_id');
            $this->SectionAnneeScolaireModel->school_id = $request->get('school_id');
            $this->SectionAnneeScolaireModel->coefficient = $request->get('coefficient');
            $this->SectionAnneeScolaireModel->save();
            return $this->helpers->apiArrayResponseBuilder(201, 'created', ['id' => $this->SectionAnneeScolaireModel->id]);
        }else{
            return $this->helpers->apiArrayResponseBuilder(400, 'fail', $validation->errors() );
        }
    }

    public function update($id, Request $request){
        $validation = Validator::make($request->all(), $this->rules, $this->messages);
        if($validation->passes()){
            $arr = $request->all();
            $section = $this->SectionAnneeScolaireModel->where('id',$id)->first();
            $section = $this->hydrate($section, $request);
            $status = $section->save();
            if( $status ){
                return $this->helpers->apiArrayResponseBuilder(200, 'success', 'Data has been updated successfully.');
            }else{
                return $this->helpers->apiArrayResponseBuilder(400, 'bad request', 'Error, data failed to update.');
            }
        }else{
            return $this->helpers->apiArrayResponseBuilder(400, 'fail', $validation->errors() );
        }
    }

    public function validate($id){
        $section = $this->SectionAnneeScolaireModel->where('id',$id)->first();
        $section->validated_at = now();
        $status = $section->save();
        if($status){
            return $this->helpers->apiArrayResponseBuilder(200, 'success', 'Data has been updated successfully.');
        }else{
            return $this->helpers->apiArrayResponseBuilder(400, 'bad request', 'Error, data failed to update.');
        }
    }

    public function delete($id){

        $this->SectionAnneeScolaireModel->where('id',$id)->delete();

        return $this->helpers->apiArrayResponseBuilder(200, 'success', 'Data has been deleted successfully.');
    }

    public function destroy($id){

        $this->SectionAnneeScolaireModel->where('id',$id)->delete();

        return $this->helpers->apiArrayResponseBuilder(200, 'success', 'Data has been deleted successfully.');
    }

    public static function getAfterFilters() {return [];}
    public static function getBeforeFilters() {return [];}
    public static function getMiddleware() {return [];}
    public function callAction($method, $parameters=false) {
        return call_user_func_array(array($this, $method), $parameters);
    }
    
}
