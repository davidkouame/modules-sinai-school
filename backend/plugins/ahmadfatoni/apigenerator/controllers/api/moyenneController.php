<?php namespace AhmadFatoni\ApiGenerator\Controllers\API;

use Cms\Classes\Controller;
use BackendMenu;

use Illuminate\Http\Request;
use AhmadFatoni\ApiGenerator\Helpers\Helpers;
use Illuminate\Support\Facades\Validator;
use BootnetCrasher\School\Models\MoyenneModel;
class moyenneController extends Controller
{
	protected $MoyenneModel;

    protected $helpers;

    public function __construct(MoyenneModel $MoyenneModel, Helpers $helpers)
    {
        parent::__construct();
        $this->MoyenneModel    = $MoyenneModel;
        $this->helpers          = $helpers;
    }

    public function index(Request $request){
        $data = $this->MoyenneModel->with(array(
            'eleve' => function($query){
                $query->select('*');
            },
            'matiere' => function($query){
                $query->select('*');
            },
            'sectionanneescolaire' => function($query){
                $query->select('*');
            },
            'anneescolaire' => function($query){
                $query->select('*');
            }
        ));
        foreach($request->except('page', 'classe_id') as $key => $value){
            if($key == "annee_scolaire_id"){
                if($request->has('type_moyenne_id') && 
                        $request->get('type_moyenne_id') == 1){
                    $data = $data->where($key, $value);
                }else{
                    // dd("nsjds");
                    $data = $data->whereHas('sectionanneescolaire', function ($query) use($request) {
                        $query->where('annee_scolaire_id', $request->get('annee_scolaire_id'))
                           ->select('*');
                    });
                }
            }elseif ($key == "professeur_id" && $request->has('classe_id')) {
                $data = $data->whereHas('classes', function ($query) use($request) {
                    $query->where('classe_id', $request->get('classe_id'))
                          ->where('professeur_id', $request->get('professeur_id'))
                          ->select('*');
                });
            }else{
                $data = $data->where($key, $value);
            }
        }
        if($request->has('classe_id')){
            $data = $data->whereHas('eleve', function ($query) use($request) {
                    $query->whereHas('classeseleves', function ($q) use($request) {
                        $q->where('classe_id', $request->get('classe_id'));
                    });
            });
        }
        $data = $data->paginate(10)->toArray();
        // dd($data);
        return $this->helpers->apiArrayResponseBuilder(200, 'success', $data);
    }
    
    public function moyenneMatiere(Request $request){

        $data = $this->MoyenneModel;
        
        foreach($request->except('page') as $key => $value){
            $data = $data->where($key, $value);
        }

        $data = $data->first();
        
        return $this->helpers->apiArrayResponseBuilder(200, 'success', $data);
    }

    public function show($id){
        $data = $this->MoyenneModel->where('id',$id)->with(array(
            'eleve' => function($query){
                $query->select('*');
            },
            'matiere' => function($query){
                $query->select('*');
            }
        ))->first();
        if($data){
            return $this->helpers->apiArrayResponseBuilder(200, 'success', $data);
        }
        $this->helpers->apiArrayResponseBuilder(400, 'bad request', ['error' => 'invalid key']);
    }

    public function store(Request $request){

    	$arr = $request->all();

        while ( $data = current($arr)) {
            $this->MoyenneModel->{key($arr)} = $data;
            next($arr);
        }

        $validation = Validator::make($request->all(), $this->MoyenneModel->rules);
        
        if( $validation->passes() ){
            $this->MoyenneModel->save();
            return $this->helpers->apiArrayResponseBuilder(201, 'created', ['id' => $this->MoyenneModel->id]);
        }else{
            return $this->helpers->apiArrayResponseBuilder(400, 'fail', $validation->errors() );
        }

    }

    public function update($id, Request $request){

        $status = $this->MoyenneModel->where('id',$id)->update($data);
    
        if( $status ){
            
            return $this->helpers->apiArrayResponseBuilder(200, 'success', 'Data has been updated successfully.');

        }else{

            return $this->helpers->apiArrayResponseBuilder(400, 'bad request', 'Error, data failed to update.');

        }
    }

    public function delete($id){

        $this->MoyenneModel->where('id',$id)->delete();

        return $this->helpers->apiArrayResponseBuilder(200, 'success', 'Data has been deleted successfully.');
    }

    public function destroy($id){

        $this->MoyenneModel->where('id',$id)->delete();

        return $this->helpers->apiArrayResponseBuilder(200, 'success', 'Data has been deleted successfully.');
    }


    public static function getAfterFilters() {return [];}
    public static function getBeforeFilters() {return [];}
    public static function getMiddleware() {return [];}
    public function callAction($method, $parameters=false) {
        return call_user_func_array(array($this, $method), $parameters);
    }
    
}