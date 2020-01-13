<?php namespace AhmadFatoni\ApiGenerator\Controllers\API;

use Cms\Classes\Controller;
use BackendMenu;

use Illuminate\Http\Request;
use AhmadFatoni\ApiGenerator\Helpers\Helpers;
use Illuminate\Support\Facades\Validator;
use BootnetCrasher\School\Models\AnneeScolaireModel;
class anneeScolaireController extends Controller
{
	protected $AnneeScolaireModel;

    protected $helpers;

    public function __construct(AnneeScolaireModel $AnneeScolaireModel, Helpers $helpers)
    {
        parent::__construct();
        $this->AnneeScolaireModel    = $AnneeScolaireModel;
        $this->helpers          = $helpers;
    }

    public function index(Request $request){
        $data = $this->AnneeScolaireModel;
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
            $data = $data->get()->toArray();
        }else{
            $data = $data->paginate(10)->toArray();
        }
        return $this->helpers->apiArrayResponseBuilder(200, 'success', $data);
    }

    public function show($id){
        $data = $this->AnneeScolaireModel->with(array(
            'typeanneescolaire'=>function($query){
                $query->select();
            }, ))->where('id',$id)->first();
        if($data){
            return $this->helpers->apiArrayResponseBuilder(200, 'success', $data);
        }
        $this->helpers->apiArrayResponseBuilder(400, 'bad request', ['error' => 'invalid key']);
    }

    public function store(Request $request){

        $arr = $request->all();

        while ( $data = current($arr)) {
            $this->AnneeScolaireModel->{key($arr)} = $data;
            next($arr);
        }

        $this->AnneeScolaireModel->type_annee_scolaire_id = $request->get('type_annee_scolaire_id');

        $validation = Validator::make($request->all(), $this->AnneeScolaireModel->rules);
        
        if( $validation->passes() ){
            $this->AnneeScolaireModel->save();
            return $this->helpers->apiArrayResponseBuilder(201, 'created', ['id' => $this->AnneeScolaireModel->id]);
        }else{
            return $this->helpers->apiArrayResponseBuilder(400, 'fail', $validation->errors() );
        }

    }

    public function update($id, Request $request){
        // $status = $this->AnneeScolaireModel->where('id',$id)->update($request->all());
        $arr = $request->all();
        $anneescolaire = $this->AnneeScolaireModel->where('id',$id)->first();
        while ( $data = current($arr)) {
            $anneescolaire->{key($arr)} = $data;
            next($arr);
        }
        $anneescolaire = $this->hydrate($anneescolaire, $request);
        // $anneescolaire->type_annee_scolaire_id = $request->get('type_annee_scolaire_id');
        $status = $anneescolaire->save();
        if( $status ){
            return $this->helpers->apiArrayResponseBuilder(200, 'success', 'Data has been updated successfully.');
        }else{
            return $this->helpers->apiArrayResponseBuilder(400, 'bad request', 'Error, data failed to update.');
        }
    }

    public function delete($id){
        $this->AnneeScolaireModel->where('id',$id)->delete();
        return $this->helpers->apiArrayResponseBuilder(200, 'success', 'Data has been deleted successfully.');
    }

    public function destroy($id){

        $this->AnneeScolaireModel->where('id',$id)->delete();

        return $this->helpers->apiArrayResponseBuilder(200, 'success', 'Data has been deleted successfully.');
    }


    public static function getAfterFilters() {return [];}
    public static function getBeforeFilters() {return [];}
    public static function getMiddleware() {return [];}
    public function callAction($method, $parameters=false) {
        return call_user_func_array(array($this, $method), $parameters);
    }
    
}